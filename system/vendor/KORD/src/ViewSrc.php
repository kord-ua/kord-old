<?php

namespace KORD;

use KORD\Core;
use KORD\Exception;
use KORD\View;
use KORD\View\Exception as ViewException;

/**
 * Acts as an object wrapper for HTML pages with embedded PHP, called "views".
 * Variables can be assigned with the view object and referenced locally within
 * the view.
 * 
 * @copyright  (c) 2007–2014 Kohana Team
 */
class ViewSrc
{

    // Array of global variables
    protected static $global_data = [];

    /**
     * Captures the output that is generated when a view is included.
     * The view data will be extracted to make local variables. This method
     * is static to prevent object scope resolution.
     *
     *     $output = \KORD\View::capture($file, $data);
     *
     * @param   string  $view_filename   filename
     * @param   array   $view_data       variables
     * @return  string
     */
    protected static function capture($view_filename, array $view_data)
    {
        // Import the view variables to local namespace
        extract($view_data, EXTR_SKIP);

        if (View::$global_data) {
            // Import the global view variables to local namespace
            extract(View::$global_data, EXTR_SKIP | EXTR_REFS);
        }

        // Capture the view output
        ob_start();

        try {
            // Load the view within the current scope
            include $view_filename;
        } catch (\Exception $e) {
            // Delete the output buffer
            ob_end_clean();

            // Re-throw the exception
            throw $e;
        }

        // Get the captured output and close the buffer
        return ob_get_clean();
    }

    /**
     * Sets a global variable, similar to [\KORD\View::set], except that the
     * variable will be accessible to all views.
     *
     *     \KORD\View::setGlobal($name, $value);
     *
     * @param   string  $key    variable name or an array of variables
     * @param   mixed   $value  value
     * @return  void
     */
    public static function setGlobal($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $key2 => $value) {
                View::$global_data[$key2] = $value;
            }
        } else {
            View::$global_data[$key] = $value;
        }
    }

    /**
     * Assigns a global variable by reference, similar to [\KORD\View::bind],
     * except that the variable will be accessible to all views.
     *
     *     \KORD\View::bindGlobal($key, $value);
     *
     * @param   string  $key    variable name
     * @param   mixed   $value  referenced variable
     * @return  void
     */
    public static function bindGlobal($key, & $value)
    {
        View::$global_data[$key] = & $value;
    }

    // View filename
    protected $file;
    // Array of local variables
    protected $data = [];

    /**
     * Sets the initial view filename and local data. Views should almost
     * always only be created using [\KORD\View::factory].
     *
     *     $view = new \KORD\View($file);
     *
     * @param   string  $file   view filename
     * @param   array   $data   array of values
     * @return  void
     * @uses    \KORD\View::setFilename
     */
    public function __construct($file = null, array $data = null)
    {
        if ($file !== null) {
            $this->setFilename($file);
        }

        if ($data !== null) {
            // Add the values to the current data
            $this->data = $data + $this->data;
        }
    }

    /**
     * Magic method, searches for the given variable and returns its value.
     * Local variables will be returned before global variables.
     *
     *     $value = $view->foo;
     *
     * [!!] If the variable has not yet been set, an exception will be thrown.
     *
     * @param   string  $key    variable name
     * @return  mixed
     * @throws  \KORD\Exception
     */
    public function & __get($key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        } elseif (array_key_exists($key, View::$global_data)) {
            return View::$global_data[$key];
        } else {
            throw new Exception('View variable is not set: {var}', ['var' => $key]);
        }
    }

    /**
     * Magic method, calls [View::set] with the same parameters.
     *
     *     $view->foo = 'something';
     *
     * @param   string  $key    variable name
     * @param   mixed   $value  value
     * @return  void
     */
    public function __set($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * Magic method, determines if a variable is set.
     *
     *     isset($view->foo);
     *
     * [!!] `null` variables are not considered to be set by [isset](http://php.net/isset).
     *
     * @param   string  $key    variable name
     * @return  boolean
     */
    public function __isset($key)
    {
        return (isset($this->data[$key]) OR isset(View::$global_data[$key]));
    }

    /**
     * Magic method, unsets a given variable.
     *
     *     unset($view->foo);
     *
     * @param   string  $key    variable name
     * @return  void
     */
    public function __unset($key)
    {
        unset($this->data[$key], View::$global_data[$key]);
    }

    /**
     * Magic method, returns the output of [\KORD\View::render].
     *
     * @return  string
     * @uses    \KORD\View::render
     */
    public function __toString()
    {
        try {
            return $this->render();
        } catch (\Exception $e) {
            /**
             * Display the exception message.
             *
             * We use this method here because it's impossible to throw an
             * exception from __toString().
             */
            $error_response = Exception::handle($e);

            return $error_response->body();
        }
    }

    /**
     * Sets the view filename.
     *
     *     $view->setFilename($file);
     *
     * @param   string  $file   view filename
     * @return  \KORD\View
     * @throws  \KORD\View\Exception
     */
    public function setFilename($file)
    {   
        if (($path = Core::findFile('views', $file)) === false) {
            throw new ViewException("The requested view '{file}' could not be found", [
                'file' => $file,
            ]);
        }
        
        // Store the file path locally
        $this->file = $path;

        return $this;
    }

    /**
     * Assigns a variable by name. Assigned values will be available as a
     * variable within the view file:
     *
     *     // This value can be accessed as $foo within the view
     *     $view->set('foo', 'my value');
     *
     * You can also use an array to set several values at once:
     *
     *     // Create the values $food and $beverage in the view
     *     $view->set(['food' => 'bread', 'beverage' => 'water']);
     *
     * @param   string  $key    variable name or an array of variables
     * @param   mixed   $value  value
     * @return  $this
     */
    public function set($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $name => $value) {
                $this->data[$name] = $value;
            }
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Assigns a value by reference. The benefit of binding is that values can
     * be altered without re-setting them. It is also possible to bind variables
     * before they have values. Assigned values will be available as a
     * variable within the view file:
     *
     *     // This reference can be accessed as $ref within the view
     *     $view->bind('ref', $bar);
     *
     * @param   string  $key    variable name
     * @param   mixed   $value  referenced variable
     * @return  $this
     */
    public function bind($key, & $value)
    {
        $this->data[$key] = & $value;

        return $this;
    }

    /**
     * Renders the view object to a string. Global and local data are merged
     * and extracted to create local variables within the view file.
     *
     *     $output = $view->render();
     *
     * [!!] Global variables with the same key name as local variables will be
     * overwritten by the local variable.
     *
     * @param   string  $file   view filename
     * @return  string
     * @throws  \KORD\View\Exception
     * @uses    \KORD\View::capture
     */
    public function render($file = null)
    {
        if ($file !== null) {
            $this->setFilename($file);
        }

        if (empty($this->file)) {
            throw new ViewException('You must set the file to use within your view before rendering');
        }

        // Combine local and global data and capture the output
        return View::capture($this->file, $this->data);
    }

}
