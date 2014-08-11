<?php

namespace KORD;

use KORD\Core;
use KORD\Exception as RequestException;
use KORD\Helper\Arr;
use KORD\Helper\Cookie;
use KORD\Helper\Server;
use KORD\Helper\URL;
use KORD\HTTP;
use KORD\HTTP\Exception as HTTPException;
use KORD\HTTP\Header as HTTPHeader;
use KORD\HTTP\Request as HTTPRequest;
use KORD\Request;
use KORD\Request\Client as RequestClient;
use KORD\Request\Client\External as RequestClientExternal;
use KORD\Request\Client\Internal as RequestClientInternal;
use KORD\Route;
use KORD\Route\Repository;

/**
 * Request. Uses the [\KORD\Route] class to determine what
 * [\KORD\Controller] to send the request to.
 *
 * @copyright  (c) 2007–2014 Kohana Team
 * @copyright  (c) 2014 Andriy Strepetov
 */
class RequestSrc implements \KORD\HTTP\Request
{
    
    /**
     * @var  Request  main request instance
     */
    protected static $initial;

    /**
     * @var  Request  currently executing request instance
     */
    protected static $current;

    /**
     * Creates a new request object for the given URI. New requests should be
     * created using the [Request::factory] method.
     *
     *     $request = \KORD\Request::factory($uri);
     *
     * If $cache parameter is set, the response for the request will attempt to
     * be retrieved from the cache.
     *
     * @param   string  $uri              URI of the request
     * @param   array   $client_params    An array of params to pass to the request client
     * @param   bool    $allow_external   Allow external requests? (deprecated in 3.3)
     * @param   array   $injected_routes  An array of routes to use, for testing
     * @return  void|\KORD\Request
     */
    public static function factory($uri = true, $client_params = [], $allow_external = true, $injected_routes = [])
    {
        // If this is the initial request
        if (!Request::$initial) {
            $protocol = HTTP::$protocol;
            
            if (Server::requestMethod() !== HTTPRequest::GET) {
                // Ensure the raw body is saved for future use
                $body = file_get_contents('php://input');
            }

            if ($uri === true) {
                // Attempt to guess the proper URI
                $uri = Server::detectUri();
            }

            $cookies = [];

            if (($cookie_keys = array_keys($_COOKIE))) {
                foreach ($cookie_keys as $key) {
                    $cookies[$key] = Cookie::get($key);
                }
            }

            // Create the instance singleton
            Request::$initial = $request = (new Request($uri, $client_params, $allow_external, $injected_routes))
                    ->protocol($protocol)
                    ->query($_GET)
                    ->post($_POST)
                    ->secure(Server::requestSecure())
                    ->method(Server::requestMethod())
                    ->referrer(Server::httpReferrer())
                    ->requestedWith(Server::requestedWith())
                    ->cookie($cookies);

            if (isset($body)) {
                // Set the request body (probably a PUT type)
                $request->body($body);
            }
        } else {
            $request = new Request($uri, $client_params, $allow_external, $injected_routes);
        }

        return $request;
    }

    /**
     * Sets or gets the currently executing request. This is changed to the current
     * request when [\KORD\Request::execute] is called and restored when the request
     * is completed.
     *
     *     // Get current request
     *     $request = \KORD\Request::current();
     * 
     *     // Set current request
     *     $request = \KORD\Request::current($request);
     *
     * @return  \KORD\Request
     */
    public static function current(Request $request = null)
    {
        if ($request !== null) {
            // Act as a setter
            Request::$initial = $request;
        }
        
        return Request::$current;
    }

    /**
     * Returns the first request encountered by this framework. This will should
     * only be set once during the first [\KORD\Request::factory] invocation.
     *
     *     // Get the first request
     *     $request = \KORD\Request::initial();
     *
     *     // Test whether the current request is the first request
     *     if (\KORD\Request::initial() === \KORD\Request::current())
     *          // Do something useful
     *
     * @return  \KORD\Request
     */
    public static function initial()
    {
        return Request::$initial;
    }

    /**
     * Process a request to find a matching route
     *
     * @param   object  $request \KORD\Request
     * @param   array   $routes  \KORD\Route
     * @return  array
     */
    public static function process(Request $request, $routes = null)
    {
        // Load routes
        $routes = (empty($routes)) ? Repository::getAll() : $routes;
        $params = null;

        foreach ($routes as $name => $route) {
            // We found something suitable
            if ($params = $route->matches($request)) {
                return [
                    'params' => $params,
                    'route' => $route,
                ];
            }
        }

        return null;
    }

    /**
     * @var  string  the x-requested-with header which most likely
     *               will be xmlhttprequest
     */
    protected $requested_with;

    /**
     * @var  string  method: GET, POST, PUT, DELETE, HEAD, etc
     */
    protected $method = 'GET';

    /**
     * @var  string  protocol: HTTP/1.1, FTP, CLI, etc
     */
    protected $protocol;

    /**
     * @var  boolean
     */
    protected $secure = false;

    /**
     * @var  string  referring URL
     */
    protected $referrer;

    /**
     * @var  \KORD\Route       route matched for this request
     */
    protected $route;

    /**
     * @var  array       array of routes to manually look at instead of the global namespace
     */
    protected $routes;

    /**
     * @var  \KORD\HTTP\Header  headers to sent as part of the request
     */
    protected $header;

    /**
     * @var  string the body
     */
    protected $body;

    /**
     * @var  string  controller namespace
     */
    protected $namespace = '';

    /**
     * @var  string  controller to be executed
     */
    protected $controller;

    /**
     * @var  string  action to be executed in the controller
     */
    protected $action;

    /**
     * @var  string  the URI of the request
     */
    protected $uri;

    /**
     * @var  boolean  external request
     */
    protected $external = false;

    /**
     * @var  array   parameters from the route
     */
    protected $params = [];

    /**
     * @var array    query parameters
     */
    protected $get = [];

    /**
     * @var array    post parameters
     */
    protected $post = [];

    /**
     * @var array    cookies to send with the request
     */
    protected $cookies = [];

    /**
     * @var \KORD\Request\Client
     */
    protected $client;

    /**
     * Creates a new request object for the given URI. New requests should be
     * created using the [\KORD\Request::factory] methods.
     *
     *     $request = new \KORD\Request($uri);
     *
     * If $cache parameter is set, the response for the request will attempt to
     * be retrieved from the cache.
     *
     * @param   string  $uri              URI of the request
     * @param   array   $client_params    Array of params to pass to the request client
     * @param   bool    $allow_external   Allow external requests? (deprecated in 3.3)
     * @param   array   $injected_routes  An array of routes to use, for testing
     * @return  void
     * @uses    \KORD\Route\Repository::getAll
     * @uses    \KORD\Route::matches
     */
    public function __construct($uri, $client_params = [], $allow_external = true, $injected_routes = [])
    {
        $client_params = is_array($client_params) ? $client_params : [];

        // Initialise the header
        $this->header = new HTTPHeader([]);

        // Assign injected routes
        $this->routes = $injected_routes;

        // Cleanse query parameters from URI (faster that parse_url())
        $split_uri = explode('?', $uri);
        $uri = array_shift($split_uri);

        // Initial request has global $_GET already applied
        if (Request::initial() !== null) {
            if ($split_uri) {
                parse_str($split_uri[0], $this->get);
            }
        }

        // Detect protocol (if present)
        // $allow_external = false prevents the default index.php from
        // being able to proxy external pages.
        if (!$allow_external OR strpos($uri, '://') === false) {
            // Remove trailing slashes from the URI
            $this->uri = trim($uri, '/');

            // Apply the client
            $this->client = new RequestClientInternal($client_params);
        } else {
            // Create a route
            $this->route = new Route($uri);

            // Store the URI
            $this->uri = $uri;

            // Set the security setting if required
            if (strpos($uri, 'https://') === 0) {
                $this->secure(true);
            }

            // Set external state
            $this->external = true;

            // Setup the client
            $this->client = RequestClientExternal::factory($client_params);
        }
    }

    /**
     * Returns the response as the string representation of a request.
     *
     *     echo $request;
     *
     * @return  string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Sets and gets the uri from the request.
     *
     * @param   string $uri
     * @return  mixed
     */
    public function uri($uri = null)
    {
        if ($uri === null) {
            // Act as a getter
            return empty($this->uri) ? '/' : $this->uri;
        }

        // Act as a setter
        $this->uri = $uri;

        return $this;
    }

    /**
     * Create a URL string from the current request. This is a shortcut for:
     *
     *     echo \KORD\Helper\URL::site($this->request->uri(), $protocol);
     *
     * @param   array    $params    URI parameters
     * @param   mixed    $protocol  protocol string or Request object
     * @return  string
     * @uses    \KORD\Helper\URL::site
     */
    public function url($protocol = null)
    {
        // Create a URI with the current route and convert it to a URL
        return URL::site($this->uri(), $protocol);
    }

    /**
     * Retrieves a value from the route parameters.
     *
     *     $id = $request->param('id');
     *
     * @param   string   $key      Key of the value
     * @param   mixed    $default  Default value if the key is not set
     * @return  mixed
     */
    public function param($key = null, $default = null)
    {
        if ($key === null) {
            // Return the full array
            return $this->params;
        }

        return isset($this->params[$key]) ? $this->params[$key] : $default;
    }

    /**
     * Sets and gets the referrer from the request.
     *
     * @param   string $referrer
     * @return  mixed
     */
    public function referrer($referrer = null)
    {
        if ($referrer === null) {
            // Act as a getter
            return $this->referrer;
        }

        // Act as a setter
        $this->referrer = (string) $referrer;

        return $this;
    }

    /**
     * Sets and gets the route from the request.
     *
     * @param   string $route
     * @return  mixed
     */
    public function route(Route $route = null)
    {
        if ($route === null) {
            // Act as a getter
            return $this->route;
        }

        // Act as a setter
        $this->route = $route;

        return $this;
    }
    
    /**
     * Sets the namespace for the controller.
     *
     * @param   string   $namespace  Namespace to execute the controller from
     * @return  mixed
     */
    public function setNamespace($namespace)
    {
        // Act as a setter
        $this->namespace = (string) $namespace;

        return $this;
    }

    /**
     * Gets the namespace of the controller.
     *
     * @param   bool   $add_slashes  Add slashes to namespace?
     * @return  mixed
     */
    public function getNamespace($add_slashes = false)
    {
        return ($add_slashes ? '\\' : '') . $this->namespace . ($add_slashes ? '\\' : '');
    }

    /**
     * Sets and gets the controller for the matched route.
     *
     * @param   string   $controller  Controller to execute the action
     * @return  mixed
     */
    public function controller($controller = null)
    {
        if ($controller === null) {
            // Act as a getter
            return $this->controller;
        }

        // Act as a setter
        $this->controller = (string) $controller;

        return $this;
    }

    /**
     * Sets and gets the action for the controller.
     *
     * @param   string   $action  Action to execute the controller from
     * @return  mixed
     */
    public function action($action = null)
    {
        if ($action === null) {
            // Act as a getter
            return $this->action;
        }

        // Act as a setter
        $this->action = (string) $action;

        return $this;
    }

    /**
     * Provides access to the [\KORD\Request\Client].
     *
     * @return  \KORD\Request\Client
     * @return  self
     */
    public function client(RequestClient $client = null)
    {
        if ($client === null) {
            return $this->client;
        } else {
            $this->client = $client;
            return $this;
        }
    }

    /**
     * Gets and sets the requested with property, which should
     * be relative to the x-requested-with pseudo header.
     *
     * @param   string    $requested_with Requested with value
     * @return  mixed
     */
    public function requestedWith($requested_with = null)
    {
        if ($requested_with === null) {
            // Act as a getter
            return $this->requested_with;
        }

        // Act as a setter
        $this->requested_with = strtolower($requested_with);

        return $this;
    }

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
     * @return  \KORD\Response
     * @throws  \KORD\Request\Exception
     * @throws  \KORD\HTTP\Exception\Code404
     * @uses    [\KORD\Core::$profiling]
     * @uses    [\KORD\Profiler]
     */
    public function execute()
    {
        if (!$this->external) {
            $processed = Request::process($this, $this->routes);

            if ($processed) {
                // Store the matching route
                $this->route = $processed['route'];
                $params = $processed['params'];

                // Is this route external?
                $this->external = $this->route->isExternal();

                if (isset($params['namespace'])) {
                    $this->namespace = $params['namespace'];
                }

                // Store the controller
                if (strpos($params['controller'], '\\') !== false) {
                    $controller_parts = explode('\\', $params['controller']);
                    $this->controller = array_pop($controller_parts);
                    $this->namespace = implode('\\', $controller_parts);
                } else {
                    $this->controller = $params['controller'];
                }

                // Store the action
                $this->action = (isset($params['action'])) ? $params['action'] : Repository::$default_action;

                // These are accessible as public vars and can be overloaded
                unset($params['controller'], $params['action'], $params['namespace']);

                // Params cannot be changed once matched
                $this->params = $params;
            }
        }

        if (!$this->route instanceof Route) {
            return HTTPException::factory(404, 'Unable to find a route to match the URI: {uri}', [
                                'uri' => $this->uri,
                            ])->request($this)
                            ->getResponse();
        }

        if (!$this->client instanceof RequestClient) {
            throw new RequestException('Unable to execute {uri} without a \KORD\Request\Client', [
                'uri' => $this->uri,
            ]);
        }

        return $this->client->execute($this);
    }

    /**
     * Returns whether this request is the initial request KORD received.
     * Can be used to test for sub requests.
     *
     *     if ( ! $request->isInitial())
     *         // This is a sub request
     *
     * @return  boolean
     */
    public function isInitial()
    {
        return ($this === Request::$initial);
    }

    /**
     * Readonly access to the [\KORD\Request::$external] property.
     *
     *     if ( ! $request->isExternal())
     *          // This is an internal request
     *
     * @return  boolean
     */
    public function isExternal()
    {
        return $this->external;
    }

    /**
     * Returns whether this is an ajax request (as used by JS frameworks)
     *
     * @return  boolean
     */
    public function isAjax()
    {
        return ($this->requested_with() === 'xmlhttprequest');
    }

    /**
     * Gets or sets the HTTP method. Usually GET, POST, PUT or DELETE in
     * traditional CRUD applications.
     *
     * @param   string   $method  Method to use for this request
     * @return  mixed
     */
    public function method($method = null)
    {
        if ($method === null) {
            // Act as a getter
            return $this->method;
        }

        // Act as a setter
        $this->method = strtoupper($method);

        return $this;
    }

    /**
     * Gets or sets the HTTP protocol. If there is no current protocol set,
     * it will use the default set in \KORD\HTTP::$protocol
     *
     * @param   string   $protocol  Protocol to set to the request
     * @return  mixed
     */
    public function protocol($protocol = null)
    {
        if ($protocol === null) {
            if ($this->protocol) {
                return $this->protocol;
            } else {
                return $this->protocol = HTTP::$protocol;
            }
        }

        // Act as a setter
        $this->protocol = strtoupper($protocol);
        return $this;
    }

    /**
     * Getter/Setter to the security settings for this request. This
     * method should be treated as immutable.
     *
     * @param   boolean $secure is this request secure?
     * @return  mixed
     */
    public function secure($secure = null)
    {
        if ($secure === null) {
            return $this->secure;
        }

        // Act as a setter
        $this->secure = (bool) $secure;
        return $this;
    }

    /**
     * Gets or sets HTTP headers of the request. All headers
     * are included immediately after the HTTP protocol definition during
     * transmission. This method provides a simple array or key/value
     * interface to the headers.
     *
     * @param   mixed   $key   Key or array of key/value pairs to set
     * @param   string  $value Value to set to the supplied key
     * @return  mixed
     */
    public function headers($key = null, $value = null)
    {
        if ($key instanceof HTTPHeader) {
            // Act a setter, replace all headers
            $this->header = $key;

            return $this;
        }

        if (is_array($key)) {
            // Act as a setter, replace all headers
            $this->header->exchangeArray($key);

            return $this;
        }

        if ($this->header->count() === 0 AND $this->isInitial()) {
            // Lazy load the request headers
            $this->header = HTTP::requestHeaders();
        }

        if ($key === null) {
            // Act as a getter, return all headers
            return $this->header;
        } elseif ($value === null) {
            // Act as a getter, single header
            return ($this->header->offsetExists($key)) ? $this->header->offsetGet($key) : null;
        }

        // Act as a setter for a single header
        $this->header[$key] = $value;

        return $this;
    }

    /**
     * Set and get cookies values for this request.
     *
     * @param   mixed    $key    Cookie name, or array of cookie values
     * @param   string   $value  Value to set to cookie
     * @return  string
     * @return  mixed
     */
    public function cookie($key = null, $value = null)
    {
        if (is_array($key)) {
            // Act as a setter, replace all cookies
            $this->cookies = $key;
            return $this;
        } elseif ($key === null) {
            // Act as a getter, all cookies
            return $this->cookies;
        } elseif ($value === null) {
            // Act as a getting, single cookie
            return isset($this->cookies[$key]) ? $this->cookies[$key] : null;
        }

        // Act as a setter for a single cookie
        $this->cookies[$key] = (string) $value;

        return $this;
    }

    /**
     * Gets or sets the HTTP body of the request. The body is
     * included after the header, separated by a single empty new line.
     *
     * @param   string  $content Content to set to the object
     * @return  mixed
     */
    public function body($content = null)
    {
        if ($content === null) {
            // Act as a getter
            return $this->body;
        }

        // Act as a setter
        $this->body = $content;

        return $this;
    }

    /**
     * Returns the length of the body for use with
     * content header
     *
     * @return  integer
     */
    public function contentLength()
    {
        return strlen($this->body());
    }

    /**
     * Renders the \KORD\HTTP\Interaction to a string, producing
     *
     *  - Protocol
     *  - Headers
     *  - Body
     *
     *  If there are variables set to the `\KORD\Request::$post`
     *  they will override any values set to body.
     *
     * @return  string
     */
    public function render()
    {
        if (!$post = $this->post()) {
            $body = $this->body();
        } else {
            $this->headers('content-type', 'application/x-www-form-urlencoded; charset=' . Core::$charset);
            $body = http_build_query($post, null, '&');
        }

        // Set the content length
        $this->headers('content-length', (string) $this->contentLength());

        // If KORD expose, set the user-agent
        if (Core::$expose) {
            $this->headers('user-agent', Core::version());
        }

        // Prepare cookies
        if ($this->cookies) {
            $cookie_string = [];

            // Parse each
            foreach ($this->cookies as $key => $value) {
                $cookie_string[] = $key . '=' . $value;
            }

            // Create the cookie string
            $this->header['cookie'] = implode('; ', $cookie_string);
        }

        $output = $this->method() . ' ' . $this->uri() . ' ' . $this->protocol() . "\r\n";
        $output .= (string) $this->header;
        $output .= $body;

        return $output;
    }

    /**
     * Gets or sets HTTP query string.
     *
     * @param   mixed   $key    Key or key value pairs to set
     * @param   string  $value  Value to set to a key
     * @return  mixed
     * @uses    \KORD\Helper\Arr::path
     */
    public function query($key = null, $value = null)
    {
        if (is_array($key)) {
            // Act as a setter, replace all query strings
            $this->get = $key;

            return $this;
        }

        if ($key === null) {
            // Act as a getter, all query strings
            return $this->get;
        } elseif ($value === null) {
            // Act as a getter, single query string
            return Arr::path($this->get, $key);
        }

        // Act as a setter, single query string
        $this->get[$key] = $value;

        return $this;
    }

    /**
     * Gets or sets HTTP POST parameters to the request.
     *
     * @param   mixed  $key    Key or key value pairs to set
     * @param   string $value  Value to set to a key
     * @return  mixed
     * @uses    \KORD\Helper\Arr::path
     */
    public function post($key = null, $value = null)
    {
        if (is_array($key)) {
            // Act as a setter, replace all fields
            $this->post = $key;

            return $this;
        }

        if ($key === null) {
            // Act as a getter, all fields
            return $this->post;
        } elseif ($value === null) {
            // Act as a getter, single field
            return Arr::path($this->post, $key);
        }

        // Act as a setter, single field
        $this->post[$key] = $value;

        return $this;
    }

}
