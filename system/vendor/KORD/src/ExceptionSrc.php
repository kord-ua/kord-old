<?php

/**
 * KORD exception class. Translates exceptions using the [I18n] class.
 */

namespace KORD;

use KORD\Core;
use KORD\Debug;
use KORD\Exception;
use KORD\HTTP\Exception as HTTPException;
use KORD\Log\Level as LogLevel;
use KORD\Response;
use KORD\View;

class ExceptionSrc extends \Exception
{

    /**
     * @var  array  PHP error code => human readable name
     */
    public static $php_errors = [
        E_ERROR => 'Fatal Error',
        E_USER_ERROR => 'User Error',
        E_PARSE => 'Parse Error',
        E_WARNING => 'Warning',
        E_USER_WARNING => 'User Warning',
        E_STRICT => 'Strict',
        E_NOTICE => 'Notice',
        E_RECOVERABLE_ERROR => 'Recoverable Error',
        E_DEPRECATED => 'Deprecated',
    ];

    /**
     * @var  string  error rendering view
     */
    public static $error_view = 'kord/error';

    /**
     * @var  string  error view content type
     */
    public static $error_view_content_type = 'text/html';

    /**
     * Creates a new translated exception.
     *
     *     throw new \KORD\Exception('Something went terrible wrong, {user}',
     *         ['user' => $user]);
     *
     * @param   string          $message    error message
     * @param   array           $variables  translation variables
     * @param   integer|string  $code       the exception code
     * @param   \Exception       $previous   Previous exception
     * @return  void
     */
    public function __construct($message = "", array $variables = null, $code = 0, \Exception $previous = null)
    {
        // Set the message
        $message = __($message, $variables);

        // Pass the message and integer code to the parent
        parent::__construct($message, (int) $code, $previous);

        // Save the unmodified code
        // @link http://bugs.php.net/39615
        $this->code = $code;
    }

    /**
     * Magic object-to-string method.
     *
     *     echo $exception;
     *
     * @uses    \KORD\Exception::text
     * @return  string
     */
    public function __toString()
    {
        return Exception::text($this);
    }

    /**
     * Inline exception handler, displays the error message, source of the
     * exception, and the stack trace of the error.
     *
     * @uses    \KORD\Exception::response
     * @param   \Exception  $e
     * @return  void
     */
    public static function handler(\Exception $e)
    {
        $response = Exception::handle($e);

        // Send the response to the browser
        echo $response->sendHeaders()->body();

        exit(1);
    }

    /**
     * Exception handler, logs the exception and generates a Response object
     * for display.
     *
     * @uses    \Kohana\Exception::response
     * @param   \Exception  $e
     * @return  \KORD\Response
     */
    public static function handle(\Exception $e)
    {
        try {
            // Log the exception
            Exception::log($e);

            // Generate the response
            $response = Exception::response($e);

            return $response;
        } catch (\Exception $e) {
            /**
             * Things are going *really* badly for us, We now have no choice
             * but to bail. Hard.
             */
            // Clean the output buffer if one exists
            ob_get_level() AND ob_clean();

            // Set the Status code to 500, and Content-Type to text/plain.
            header('Content-Type: text/plain; charset=' . Core::$charset, true, 500);

            echo Exception::text($e);

            exit(1);
        }
    }

    /**
     * Logs an exception.
     *
     * @uses    \KORD\Exception::text
     * @param   \Exception  $e
     * @param   int        $level
     * @return  void
     */
    public static function log(\Exception $e, $level = LogLevel::EMERGENCY)
    {
        if (is_object(Core::$log)) {
            // Create a text version of the exception
            $error = Exception::text($e);

            // Add this exception to the log
            Core::$log->log($level, $error, [], ['exception' => $e]);

            // Make sure the logs are written
            Core::$log->write();
        }
    }

    /**
     * Get a single line of text representing the exception:
     *
     * Error [ Code ]: Message ~ File [ Line ]
     *
     * @param   \Exception  $e
     * @return  string
     */
    public static function text(\Exception $e)
    {
        return sprintf('%s [ %s ]: %s ~ %s [ %d ]', get_class($e), $e->getCode(), strip_tags($e->getMessage()), Debug::path($e->getFile()), $e->getLine());
    }

    /**
     * Get a Response object representing the exception
     *
     * @uses    \KORD\Exception::text
     * @param   \Exception  $e
     * @return  Response
     */
    public static function response(\Exception $e)
    {
        try {
            // Get the exception information
            $class = get_class($e);
            $code = $e->getCode();
            $message = $e->getMessage();
            $file = $e->getFile();
            $line = $e->getLine();
            $trace = $e->getTrace();

            /**
             * \HTTP\Exceptions are constructed in the \HTTP\Exception::factory()
             * method. We need to remove that entry from the trace and overwrite
             * the variables from above.
             */
            if ($e instanceof HTTPException AND $trace[0]['function'] == 'factory') {
                extract(array_shift($trace));
            }


            if ($e instanceof \ErrorException) {
                /**
                 * If XDebug is installed, and this is a fatal error,
                 * use XDebug to generate the stack trace
                 */
                if (function_exists('xdebug_get_function_stack') AND $code == E_ERROR) {
                    $trace = array_slice(array_reverse(xdebug_get_function_stack()), 4);

                    foreach ($trace as & $frame) {
                        /**
                         * XDebug pre 2.1.1 doesn't currently set the call type key
                         * http://bugs.xdebug.org/view.php?id=695
                         */
                        if (!isset($frame['type'])) {
                            $frame['type'] = '??';
                        }

                        // XDebug also has a different name for the parameters array
                        if (isset($frame['params']) AND ! isset($frame['args'])) {
                            $frame['args'] = $frame['params'];
                        }
                    }
                }

                if (isset(Exception::$php_errors[$code])) {
                    // Use the human-readable error name
                    $code = Exception::$php_errors[$code];
                }
            }

            /**
             * The stack trace becomes unmanageable inside PHPUnit.
             *
             * The error view ends up several GB in size, taking
             * serveral minutes to render.
             */
            if (defined('PHPUnit_MAIN_METHOD')) {
                $trace = array_slice($trace, 0, 2);
            }

            // Instantiate the error view.
            $view = new View(Exception::$error_view, get_defined_vars());

            // Prepare the response object.
            $response = new Response;

            // Set the response status
            $response->status(($e instanceof HTTPException) ? $e->getCode() : 500);

            // Set the response headers
            $response->headers('Content-Type', Exception::$error_view_content_type . '; charset=' . Core::$charset);

            // Set the response body
            $response->body($view->render());
        } catch (Exception $e) {
            /**
             * Things are going badly for us, Lets try to keep things under control by
             * generating a simpler response object.
             */
            $response = new Response;
            $response->status(500);
            $response->headers('Content-Type', 'text/plain');
            $response->body(Exception::text($e));
        }

        return $response;
    }

}
