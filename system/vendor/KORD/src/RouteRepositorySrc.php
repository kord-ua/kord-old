<?php

/**
 * Routes are used to determine the controller and action for a requested URI.
 * Every route generates a regular expression which is used to match a URI
 * and a route. Routes may also contain keys which can be used to set the
 * controller, action, and parameters.
 *
 * Each <key> will be translated to a regular expression using a default
 * regular expression pattern. You can override the default pattern by providing
 * a pattern for the key:
 *
 *     // This route will only match when <id> is a digit
 *     \KORD\RouteRepository::set('user', 'user/<action>/<id>', ['id' => '\d+']);
 *
 *     // This route will match when <path> is anything
 *     \KORD\RouteRepository::set('file', '<path>', ['path' => '.*']);
 *
 * It is also possible to create optional segments by using parentheses in
 * the URI definition:
 *
 *     // This is the standard default route, and no keys are required
 *     \KORD\RouteRepository::set('default', '(<controller>(/<action>(/<id>)))');
 *
 *     // This route only requires the <file> key
 *     \KORD\RouteRepository::set('file', '(<path>/)<file>(.<format>)', ['path' => '.*', 'format' => '\w+']);
 *
 * Routes also provide a way to generate URIs (called "reverse routing"), which
 * makes them an extremely powerful and flexible way to generate internal links.
 */

namespace KORD;

use KORD\Core;
use KORD\Exception;
use KORD\Route;
use KORD\RouteRepository;
use KORD\URL;

class RouteRepositorySrc
{

    // Matches a URI group and captures the contents
    const REGEX_GROUP = '\(((?:(?>[^()]+)|(?R))*)\)';
    // Defines the pattern of a <segment>
    const REGEX_KEY = '<([a-zA-Z0-9_]++)>';
    // What can be part of a <segment> value
    const REGEX_SEGMENT = '[^/.,;?\n]++';
    // What must be escaped in the route regex
    const REGEX_ESCAPE = '[.\\+*?[^\\]${}=!|]';

    /**
     * @var  string  default protocol for all routes
     *
     * @example  'http://'
     */
    public static $default_protocol = 'http://';

    /**
     * @var  array   list of valid localhost entries
     */
    public static $localhosts = [false, '', 'local', 'localhost'];

    /**
     * @var  string  default action for all routes
     */
    public static $default_action = 'index';

    /**
     * @var  bool Indicates whether routes are cached
     */
    public static $cache = false;

    /**
     * @var  array
     */
    protected static $routes = [];

    /**
     * Stores a named route and returns it. The "action" will always be set to
     * "index" if it is not defined.
     *
     *     \KORD\RouteRepository::set('default', '(<controller>(/<action>(/<id>)))')
     *         ->defaults([
     *             'controller' => 'welcome',
     *         ]);
     *
     * @param   string  $name           route name
     * @param   string  $uri            URI pattern
     * @param   array   $regex          regex patterns for route keys
     * @return  \KORD\Route
     */
    public static function set($name, $uri = null, $regex = null)
    {
        return RouteRepository::$routes[$name] = new Route($uri, $regex);
    }

    /**
     * Retrieves a named route.
     *
     *     $route = \KORD\RouteRepository::get('default');
     *
     * @param   string  $name   route name
     * @return  \KORD\Route
     * @throws  \KORD\Exception
     */
    public static function get($name)
    {
        if (!isset(RouteRepository::$routes[$name])) {
            throw new Exception('The requested route does not exist: {route}', ['route' => $name]);
        }

        return RouteRepository::$routes[$name];
    }

    /**
     * Retrieves all named routes.
     *
     *     $routes = \KORD\RouteRepository::getAll();
     *
     * @return  array  routes by name
     */
    public static function getAll()
    {
        return RouteRepository::$routes;
    }

    /**
     * Get the name of a route.
     *
     *     $name = \KORD\RouteRepository::name($route)
     *
     * @param   \KORD\Route   $route  instance
     * @return  string
     */
    public static function name(Route $route)
    {
        return array_search($route, RouteRepository::$routes);
    }

    /**
     * Saves or loads the route cache. If your routes will remain the same for
     * a long period of time, use this to reload the routes from the cache
     * rather than redefining them on every page load.
     *
     *     if ( ! \KORD\RouteRepository::cache())
     *     {
     *         // Set routes here
     *         \KORD\RouteRepository::cache(true);
     *     }
     *
     * @param   boolean $save   cache the current routes
     * @param   boolean $append append, rather than replace, cached routes when loading
     * @return  void    when saving routes
     * @return  boolean when loading routes
     * @uses    \KORD\Core::cache
     */
    public static function cache($save = false, $append = false)
    {
        if ($save === true) {
            try {
                // Cache all defined routes
                Core::cache('\KORD\RouteRepository::cache()', RouteRepository::$routes);
            } catch (\Exception $e) {
                // We most likely have a lambda in a route, which cannot be cached
                throw new Exception('One or more routes could not be cached ({message})', [
                    'message' => $e->getMessage(),
                ], 0, $e);
            }
        } else {
            if ($routes = Core::cache('\KORD\RouteRepository::cache()')) {
                if ($append) {
                    // Append cached routes
                    RouteRepository::$routes += $routes;
                } else {
                    // Replace existing routes
                    RouteRepository::$routes = $routes;
                }

                // Routes were cached
                return RouteRepository::$cache = true;
            } else {
                // Routes were not cached
                return RouteRepository::$cache = false;
            }
        }
    }

    /**
     * Create a URL from a route name. This is a shortcut for:
     *
     *     echo \KORD\URL::site(\KORD\RouteRepository::get($name)->uri($params), $protocol);
     *
     * @param   string  $name       route name
     * @param   array   $params     URI parameters
     * @param   mixed   $protocol   protocol string or boolean, adds protocol and domain
     * @return  string
     * @uses    \KORD\URL::site
     */
    public static function url($name, array $params = null, $protocol = null)
    {
        $route = RouteRepository::get($name);

        // Create a URI with the route and convert it to a URL
        if ($route->isExternal()) {
            return $route->uri($params);
        } else {
            return URL::site($route->uri($params), $protocol);
        }
    }

    /**
     * Returns the compiled regular expression for the route. This translates
     * keys and optional groups to a proper PCRE regular expression.
     *
     *     $compiled = \KORD\RouteRepository::compile(
     *        '<controller>(/<action>(/<id>))',
     *         [
     *           'controller' => '[a-z]+',
     *           'id' => '\d+',
     *         ]
     *     );
     *
     * @return  string
     * @uses    \KORD\RouteRepository::REGEX_ESCAPE
     * @uses    \KORD\RouteRepository::REGEX_SEGMENT
     */
    public static function compile($uri, array $regex = null)
    {
        // The URI should be considered literal except for keys and optional parts
        // Escape everything preg_quote would escape except for : ( ) < >
        $expression = preg_replace('#' . RouteRepository::REGEX_ESCAPE . '#', '\\\\$0', $uri);

        if (strpos($expression, '(') !== false) {
            // Make optional parts of the URI non-capturing and optional
            $expression = str_replace(['(', ')'], ['(?:', ')?'], $expression);
        }

        // Insert default regex for keys
        $expression = str_replace(['<', '>'], ['(?P<', '>' . RouteRepository::REGEX_SEGMENT . ')'], $expression);

        if ($regex) {
            $search = $replace = [];
            foreach ($regex as $key => $value) {
                $search[] = "<$key>" . RouteRepository::REGEX_SEGMENT;
                $replace[] = "<$key>$value";
            }

            // Replace the default regex with the user-specified regex
            $expression = str_replace($search, $replace, $expression);
        }

        return '#^' . $expression . '$#uD';
    }

}
