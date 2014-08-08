<?php

namespace KORD\Request\Client;

use KORD\Core;
use KORD\Profiler;
use KORD\Request;
use KORD\Request\Client\External as RequestClientExternal;
use KORD\Request\Exception as RequestException;
use KORD\Response;

/**
 * [\KORD\Request\Client\External] provides a wrapper for all external request
 * processing. This class should be extended by all drivers handling external
 * requests.
 *
 * Supported out of the box:
 *  - Curl (default)
 *  - PECL HTTP
 *  - Streams
 *
 * To select a specific external driver to use as the default driver, set the
 * following property within the Application bootstrap. Alternatively, the
 * client can be injected into the request object.
 *
 * @example
 *
 *       // In application bootstrap
 *       \KORD\Request\Client\External::$client = '\KORD\Request\Client\Stream';
 *
 *       // Add client to request
 *       $request = \KORD\Request::factory('http://some.host.tld/foo/bar')
 *           ->client(\KORD\Request\Client\External::factory('\KORD\Request\Client\HTTP));
 *
 * @copyright  (c) 2007–2014 Kohana Team
 * @uses       [PECL HTTP](http://php.net/manual/en/book.http.php)
 */
abstract class ExternalSrc extends \KORD\Request\Client
{

    /**
     * Use:
     *  - \KORD\Request\Client\Curl (default)
     *  - \KORD\Request\Client\HTTP
     *  - \KORD\Request\Client\Stream
     *
     * @var     string    defines the external client to use by default
     */
    public static $client = '\KORD\Request\Client\Curl';

    /**
     * Factory method to create a new Request_Client_External object based on
     * the client name passed, or defaulting to \KORD\Request\Client\External::$client
     * by default.
     *
     * \KORD\Request\Client\External::$client can be set in the application bootstrap.
     *
     * @param   array   $params parameters to pass to the client
     * @param   string  $client external client to use
     * @return  \KORD\Request\Client\External
     * @throws  \KORD\Exception
     */
    public static function factory(array $params = [], $client = null)
    {
        if ($client === null) {
            $client = RequestClientExternal::$client;
        }

        $client = new $client($params);

        if (!$client instanceof RequestClientExternal) {
            throw new RequestException('Selected client is not a \KORD\Request\Client\External object.');
        }

        return $client;
    }

    /**
     * @var     array     curl options
     * @link    http://www.php.net/manual/function.curl-setopt
     * @link    http://www.php.net/manual/http.request.options
     */
    protected $options = [];

    /**
     * Processes the request, executing the controller action that handles this
     * request, determined by the [\KORD\Route].
     *
     * 1. Before the controller action is called, the [\KORD\Controller::before] 
     * method will be called.
     * 2. Next the controller action will be called.
     * 3. After the controller action is called, the [\KORD\Controller::after] 
     * method will be called.
     *
     * By default, the output from the controller is captured and returned, and
     * no headers are sent.
     *
     *     $request->execute();
     *
     * @param   \KORD\Request   $request
     * @param   \KORD\Response  $response
     * @return  \KORD\Response
     * @throws  \KORD\Exception
     * @uses    [\KORD\Core::$profiling]
     * @uses    [\KORD\Profiler]
     */
    public function executeRequest(Request $request, Response $response)
    {
        if (Core::$profiling) {
            // Set the benchmark name
            $benchmark = '"' . $request->uri() . '"';

            if ($request !== Request::initial() AND Request::current()) {
                // Add the parent request uri
                $benchmark .= ' « "' . Request::current()->uri() . '"';
            }

            // Start benchmarking
            $benchmark = Profiler::start('Request', $benchmark);
        }

        // Store the current active request and replace current with new request
        $previous = Request::current();
        Request::current($request);

        // Resolve the POST fields
        if ($post = $request->post()) {
            $request->body(http_build_query($post, null, '&'))
                    ->headers('content-type', 'application/x-www-form-urlencoded; charset=' . Core::$charset);
        }

        // If KORD expose, set the user-agent
        if (Core::$expose) {
            $request->headers('user-agent', Core::version());
        }

        try {
            $response = $this->sendMessage($request, $response);
        } catch (\Exception $e) {
            // Restore the previous request
            Request::current($previous);

            if (isset($benchmark)) {
                // Delete the benchmark, it is invalid
                Profiler::delete($benchmark);
            }

            // Re-throw the exception
            throw $e;
        }

        // Restore the previous request
        Request::current($previous);

        if (isset($benchmark)) {
            // Stop the benchmark
            Profiler::stop($benchmark);
        }

        // Return the response
        return $response;
    }

    /**
     * Set and get options for this request.
     *
     * @param   mixed    $key    Option name, or array of options
     * @param   mixed    $value  Option value
     * @return  mixed
     * @return  \KORD\Request\Client\External
     */
    public function options($key = null, $value = null)
    {
        if ($key === null) {
            return $this->options;
        }

        if (is_array($key)) {
            $this->options = $key;
        } elseif ($value === null) {
            return Arr::get($this->options, $key);
        } else {
            $this->options[$key] = $value;
        }

        return $this;
    }

    /**
     * Sends the HTTP message [\KORD\Request] to a remote server and processes
     * the response.
     *
     * @param   \KORD\Request   $request    Request to send
     * @param   \KORD\Response  $response   Response to send
     * @return  \KORD\Response
     */
    abstract protected function sendMessage(Request $request, Response $response);
}
