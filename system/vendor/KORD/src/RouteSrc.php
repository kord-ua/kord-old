<?php

/**
 * Routes are used to determine the controller and action for a requested URI.
 * Every route generates a regular expression which is used to match a URI
 * and a route. Routes may also contain keys which can be used to set the
 * controller, action, and parameters.
 * 
 * @copyright  (c) 2007–2014 Kohana Team
 */

namespace KORD;

use KORD\Arr;
use KORD\Exception;
use KORD\Request;
use KORD\RouteRepository;

class RouteSrc
{
    /**
     * @var  array  route filters
     */
    protected $filters = [];

    /**
     * @var  string  route URI
     */
    protected $uri = '';

    /**
     * @var  array
     */
    protected $regex = [];

    /**
     * @var  array
     */
    protected $defaults = ['action' => 'index', 'host' => false];

    /**
     * @var  string
     */
    protected $route_regex;

    /**
     * Creates a new route. Sets the URI and regular expressions for keys.
     * Routes should always be created with [\KORD\RouteRepository::set] or 
     * they will not be properly stored.
     *
     *     $route = new \KORD\Route($uri, $regex);
     *
     * The $uri parameter should be a string for basic regex matching.
     *
     *
     * @param   string  $uri    route URI pattern
     * @param   array   $regex  key patterns
     * @return  void
     * @uses    \KORD\RouteRepository::compile
     */
    public function __construct($uri = null, $regex = null)
    {
        if ($uri === null) {
            // Assume the route is from cache
            return;
        }

        if (!empty($uri)) {
            $this->uri = $uri;
        }

        if (!empty($regex)) {
            $this->regex = $regex;
        }

        // Store the compiled regex locally
        $this->route_regex = \KORD\RouteRepository::compile($uri, $regex);
    }

    /**
     * Provides default values for keys when they are not present. The default
     * action will always be "index" unless it is overloaded here.
     *
     *     $route->defaults([
     *         'controller' => 'welcome',
     *         'action'     => 'index'
     *     ]);
     *
     * If no parameter is passed, this method will act as a getter.
     *
     * @param   array   $defaults   key values
     * @return  $this or array
     */
    public function defaults(array $defaults = null)
    {
        if ($defaults === null) {
            return $this->defaults;
        }

        $this->defaults = $defaults;

        return $this;
    }

    /**
     * Filters to be run before route parameters are returned:
     *
     *     $route->filter(
     *         function(\KORD\Route $route, $params, \KORD\Request $request)
     *         {
     *             if ($request->method() !== \KORD\HTTP\Request::POST)
     *             {
     *                 return false; // This route only matches POST requests
     *             }
     *             if ($params AND $params['controller'] === 'welcome')
     *             {
     *                 $params['controller'] = 'home';
     *             }
     *
     *             return $params;
     *         }
     *     );
     *
     * To prevent a route from matching, return `false`. To replace the route
     * parameters, return an array.
     *
     * [!!] Default parameters are added before filters are called!
     *
     * @throws  \KORD\Exception
     * @param   array   $callback   callback string, array, or closure
     * @return  $this
     */
    public function filter($callback)
    {
        if (!is_callable($callback)) {
            throw new Exception('Invalid \KORD\Route::callback specified');
        }

        $this->filters[] = $callback;

        return $this;
    }

    /**
     * Tests if the route matches a given Request. A successful match will return
     * all of the routed parameters as an array. A failed match will return
     * boolean false.
     *
     *     // Params: controller = users, action = edit, id = 10
     *     $params = $route->matches(\KORD\Request::factory('users/edit/10'));
     *
     * This method should almost always be used within an if/else block:
     *
     *     if ($params = $route->matches($request))
     *     {
     *         // Parse the parameters
     *     }
     *
     * @param   \KORD\Request $request  Request object to match
     * @return  array             on success
     * @return  false             on failure
     */
    public function matches(Request $request)
    {
        // Get the URI from the Request
        $uri = trim($request->uri(), '/');

        if (!preg_match($this->route_regex, $uri, $matches)) {
            return false;
        }

        $params = [];
        foreach ($matches as $key => $value) {
            if (is_int($key)) {
                // Skip all unnamed keys
                continue;
            }

            // Set the value for all matched keys
            $params[$key] = $value;
        }

        foreach ($this->defaults as $key => $value) {
            if (!isset($params[$key]) OR $params[$key] === '') {
                // Set default values for any key that was not matched
                $params[$key] = $value;
            }
        }

        if (!empty($params['controller'])) {
            // PSR-0: Replace underscores with spaces, run ucwords, then replace underscore
            $params['controller'] = str_replace(' ', '_', ucwords(str_replace('_', ' ', $params['controller'])));
        }

        if (!empty($params['directory'])) {
            // PSR-0: Replace underscores with spaces, run ucwords, then replace underscore
            $params['directory'] = str_replace(' ', '_', ucwords(str_replace('_', ' ', $params['directory'])));
        }

        if ($this->filters) {
            foreach ($this->filters as $callback) {
                // Execute the filter giving it the route, params, and request
                $return = call_user_func($callback, $this, $params, $request);

                if ($return === false) {
                    // Filter has aborted the match
                    return false;
                } elseif (is_array($return)) {
                    // Filter has modified the parameters
                    $params = $return;
                }
            }
        }

        return $params;
    }

    /**
     * Returns whether this route is an external route
     * to a remote controller.
     *
     * @return  boolean
     */
    public function isExternal()
    {
        return !in_array(Arr::get($this->defaults, 'host', false), RouteRepository::$localhosts);
    }

    /**
     * Generates a URI for the current route based on the parameters given.
     *
     *     // Using the "default" route: "users/profile/10"
     *     $route->uri([
     *         'controller' => 'users',
     *         'action'     => 'profile',
     *         'id'         => '10'
     *     ]);
     *
     * @param   array   $params URI parameters
     * @return  string
     * @throws  \KORD\Exception
     * @uses    \KORD\RouteRepository::REGEX_GROUP
     * @uses    \KORD\RouteRepository::REGEX_KEY
     */
    public function uri(array $params = null)
    {
        $defaults = $this->defaults;

        /**
         * Recursively compiles a portion of a URI specification by replacing
         * the specified parameters and any optional parameters that are needed.
         *
         * @param   string  $portion    Part of the URI specification
         * @param   boolean $required   Whether or not parameters are required (initially)
         * @return  array   Tuple of the compiled portion and whether or not it contained specified parameters
         */
        $compile = function ($portion, $required) use (&$compile, $defaults, $params) {
            $missing = [];

            $pattern = '#(?:' . RouteRepository::REGEX_KEY . '|' . RouteRepository::REGEX_GROUP . ')#';
            $result = preg_replace_callback($pattern, function ($matches) use (&$compile, $defaults, &$missing, $params, &$required) {
                if ($matches[0][0] === '<') {
                    // Parameter, unwrapped
                    $param = $matches[1];

                    if (isset($params[$param])) {
                        // This portion is required when a specified
                        // parameter does not match the default
                        $required = ($required OR ! isset($defaults[$param]) OR $params[$param] !== $defaults[$param]);

                        // Add specified parameter to this result
                        return $params[$param];
                    }

                    // Add default parameter to this result
                    if (isset($defaults[$param])) {
                        return $defaults[$param];
                    }

                    // This portion is missing a parameter
                    $missing[] = $param;
                }
                else {
                    // Group, unwrapped
                    $result = $compile($matches[2], false);

                    if ($result[1]) {
                        // This portion is required when it contains a group
                        // that is required
                        $required = true;

                        // Add required groups to this result
                        return $result[0];
                    }

                    // Do not add optional groups to this result
                }
            }, $portion);

            if ($required AND $missing) {
                throw new Exception(
                'Required route parameter not passed: {param}', ['param' => reset($missing)]
                );
            }

            return array($result, $required);
        };

        list($uri) = $compile($this->uri, true);

        // Trim all extra slashes from the URI
        $uri = preg_replace('#//+#', '/', rtrim($uri, '/'));

        if ($this->isExternal()) {
            // Need to add the host to the URI
            $host = $this->defaults['host'];

            if (strpos($host, '://') === false) {
                // Use the default defined protocol
                $host = RouteRepository::$default_protocol . $host;
            }

            // Clean up the host and prepend it to the URI
            $uri = rtrim($host, '/') . '/' . $uri;
        }

        return $uri;
    }

}
