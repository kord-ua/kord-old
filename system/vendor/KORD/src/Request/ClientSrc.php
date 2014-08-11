<?php

namespace KORD\Request;

use KORD\Request;
use KORD\Request\Client as RequestClient;
use KORD\Request\Client\Recursion\Exception as RequestClientRecursionException;
use KORD\Response;

/**
 * Request Client. Processes a [\KORD\Request] and handles [\KORD\HTTP\Caching] if
 * available. Will usually return a [\KORD\Response] object as a result of the
 * request unless an unexpected error occurs.
 * 
 * @copyright  (c) 2007–2014 Kohana Team
 * @copyright  (c) 2014 Andriy Strepetov
 */
abstract class ClientSrc
{

    /**
     * @var    \KORD\Cache  Caching library for request caching
     */
    protected $cache;

    /**
     * @var  bool  Should redirects be followed?
     */
    protected $follow = false;

    /**
     * @var  array  Headers to preserve when following a redirect
     */
    protected $follow_headers = ['Authorization'];

    /**
     * @var  bool  Follow 302 redirect with original request method?
     */
    protected $strict_redirect = true;

    /**
     * @var array  Callbacks to use when response contains given headers
     */
    protected $header_callbacks = [
        'Location' => '\KORD\Request\Client::onHeaderLocation'
    ];

    /**
     * @var int  Maximum number of requests that header callbacks can trigger before the request is aborted
     */
    protected $max_callback_depth = 5;

    /**
     * @var int  Tracks the callback depth of the currently executing request
     */
    protected $callback_depth = 1;

    /**
     * @var array  Arbitrary parameters that are shared with header callbacks through their \KORD\Request\Client object
     */
    protected $callback_params = [];

    /**
     * Creates a new `\KORD\Request\Client` object,
     * allows for dependency injection.
     *
     * @param   array    $params Params
     */
    public function __construct(array $params = [])
    {
        foreach ($params as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }
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
     * @param   \KORD\Request   $request
     * @param   \KORD\Response  $response
     * @return  \KORD\Response
     * @throws  \KORD\Request\Client\Recursion\Exception
     * @uses    [\KORD\Core::$profiling]
     * @uses    [\KORD\Profiler]
     */
    public function execute(Request $request)
    {
        // Prevent too much recursion of header callback requests
        if ($this->callbackDepth() > $this->maxCallbackDepth()) {
            throw new RequestClientRecursionException(
            "Could not execute request to {uri} - too many recursions after {depth} requests", [
                'uri' => $request->uri(),
                'depth' => $this->callbackDepth() - 1,
            ]);
        }

        // Execute the request and pass the currently used protocol
        $orig_response = $response = new Response(['protocol' => $request->protocol()]);

        if (($cache = $this->cache()) instanceof \KORD\HTTP\Cache) {
            return $cache->execute($this, $request, $response);
        }

        $response = $this->executeRequest($request, $response);

        // Execute response callbacks
        foreach ($this->headerCallbacks() as $header => $callback) {
            if ($response->headers($header)) {
                $cb_result = call_user_func($callback, $request, $response, $this);

                if ($cb_result instanceof Request) {
                    // If the callback returns a request, automatically assign client params
                    $this->assignClientProperties($cb_result->client());
                    $cb_result->client()->callbackDepth($this->callbackDepth() + 1);

                    // Execute the request
                    $response = $cb_result->execute();
                } elseif ($cb_result instanceof Response) {
                    // Assign the returned response
                    $response = $cb_result;
                }

                // If the callback has created a new response, do not process any further
                if ($response !== $orig_response) {
                    break;
                }
            }
        }

        return $response;
    }

    /**
     * Processes the request passed to it and returns the response from
     * the URI resource identified.
     *
     * This method must be implemented by all clients.
     *
     * @param   \KORD\Request   $request   request to execute by client
     * @param   \KORD\Response  $response
     * @return  \KORD\Response
     */
    abstract public function executeRequest(Request $request, Response $response);

    /**
     * Getter and setter for the internal caching engine,
     * used to cache responses if available and valid.
     *
     * @param   \KORD\HTTP\Cache  $cache  engine to use for caching
     * @return  \KORD\HTTP\Cache
     * @return  \KORD\Request\Client
     */
    public function cache(\KORD\HTTP\Cache $cache = null)
    {
        if ($cache === null) {
            return $this->cache;
        }

        $this->cache = $cache;
        return $this;
    }

    /**
     * Getter and setter for the follow redirects
     * setting.
     *
     * @param   bool  $follow  Boolean indicating if redirects should be followed
     * @return  bool
     * @return  \KORD\Request\Client
     */
    public function follow($follow = null)
    {
        if ($follow === null) {
            return $this->follow;
        }

        $this->follow = $follow;

        return $this;
    }

    /**
     * Getter and setter for the follow redirects
     * headers array.
     *
     * @param   array  $follow_headers  Array of headers to be re-used when following a Location header
     * @return  array
     * @return  \KORD\Request\Client
     */
    public function followHeaders($follow_headers = null)
    {
        if ($follow_headers === null) {
            return $this->follow_headers;
        }

        $this->follow_headers = $follow_headers;

        return $this;
    }

    /**
     * Getter and setter for the strict redirects setting
     *
     * [!!] HTTP/1.1 specifies that a 302 redirect should be followed using the
     * original request method. However, the vast majority of clients and servers
     * get this wrong, with 302 widely used for 'POST - 302 redirect - GET' patterns.
     * By default, KORD's client is fully compliant with the HTTP spec. Some
     * non-compliant third party sites may require that strict_redirect is set
     * false to force the client to switch to GET following a 302 response.
     *
     * @param  bool  $strict_redirect  Boolean indicating if 302 redirects should be followed with the original method
     * @return \KORD\Request\Client
     */
    public function strictRedirect($strict_redirect = null)
    {
        if ($strict_redirect === null) {
            return $this->strict_redirect;
        }

        $this->strict_redirect = $strict_redirect;

        return $this;
    }

    /**
     * Getter and setter for the header callbacks array.
     *
     * Accepts an array with HTTP response headers as keys and a PHP callback
     * function as values. These callbacks will be triggered if a response contains
     * the given header and can either issue a subsequent request or manipulate
     * the response as required.
     *
     * By default, the [\KORD\Request\Client::onHeaderLocation] callback is assigned
     * to the Location header to support automatic redirect following.
     *
     *     $client->headerCallbacks([
     *         'Location' => '\KORD\Request\Client::onHeaderLocation',
     *         'WWW-Authenticate' => function($request, $response, $client) {return $new_response;},
     *     ]);
     *
     * @param array $header_callbacks	Array of callbacks to trigger on presence of given headers
     * @return \KORD\Request\Client
     */
    public function headerCallbacks($header_callbacks = null)
    {
        if ($header_callbacks === null) {
            return $this->header_callbacks;
        }

        $this->header_callbacks = $header_callbacks;

        return $this;
    }

    /**
     * Getter and setter for the maximum callback depth property.
     *
     * This protects the main execution from recursive callback execution (eg
     * following infinite redirects, conflicts between callbacks causing loops
     * etc). Requests will only be allowed to nest to the level set by this
     * param before execution is aborted with a \KORD\Exception.
     *
     * @param int $depth  Maximum number of callback requests to execute before aborting
     * @return \KORD\Request\Client|int
     */
    public function maxCallbackDepth($depth = null)
    {
        if ($depth === null) {
            return $this->max_callback_depth;
        }

        $this->max_callback_depth = $depth;

        return $this;
    }

    /**
     * Getter/Setter for the callback depth property, which is used to track
     * how many recursions have been executed within the current request execution.
     *
     * @param int $depth  Current recursion depth
     * @return \KORD\Request\Client|int
     */
    public function callbackDepth($depth = null)
    {
        if ($depth === null) {
            return $this->callback_depth;
        }

        $this->callback_depth = $depth;

        return $this;
    }

    /**
     * Getter/Setter for the callback_params array, which allows additional
     * application-specific parameters to be shared with callbacks.
     *
     * As with other KORD setter/getters, usage is:
     *
     *     // Set full array
     *     $client->callbackParams(['foo'=>'bar']);
     *
     *     // Set single key
     *     $client->callbackParams('foo','bar');
     *
     *     // Get full array
     *     $params = $client->callbackParams();
     *
     *     // Get single key
     *     $foo = $client->callbackParams('foo');
     *
     * @param string|array $param
     * @param mixed $value
     * @return \KORD\Request\Client|mixed
     */
    public function callbackParams($param = null, $value = null)
    {
        // Getter for full array
        if ($param === null) {
            return $this->callback_params;
        }

        // Setter for full array
        if (is_array($param)) {
            $this->callback_params = $param;
            return $this;
        }
        // Getter for single value
        elseif ($value === null) {
            return Arr::get($this->callback_params, $param);
        }
        // Setter for single value
        else {
            $this->callback_params[$param] = $value;
            return $this;
        }
    }

    /**
     * Assigns the properties of the current \KORD\Request\Client to another
     * \KORD\Request\Client instance - used when setting up a subsequent request.
     *
     * @param \KORD\Request\Client $client
     */
    public function assignClientProperties(RequestClient $client)
    {
        $client->cache($this->cache());
        $client->follow($this->follow());
        $client->followHeaders($this->followHeaders());
        $client->headerCallbacks($this->headerCallbacks());
        $client->maxCallbackDepth($this->maxCallbackDepth());
        $client->callbackParams($this->callbackParams());
    }

    /**
     * The default handler for following redirects, triggered by the presence of
     * a Location header in the response.
     *
     * The client's follow property must be set true and the HTTP response status
     * one of 201, 301, 302, 303 or 307 for the redirect to be followed.
     *
     * @param \KORD\Request $request
     * @param \KORD\Response $response
     * @param \KORD\Request\Client $client
     */
    public static function onHeaderLocation(Request $request, Response $response, RequestClient $client)
    {
        // Do we need to follow a Location header ?
        if ($client->follow() AND in_array($response->status(), [201, 301, 302, 303, 307])) {
            // Figure out which method to use for the follow request
            switch ($response->status()) {
                default:
                case 301:
                case 307:
                    $follow_method = $request->method();
                    break;
                case 201:
                case 303:
                    $follow_method = Request::GET;
                    break;
                case 302:
                    // Cater for sites with broken HTTP redirect implementations
                    if ($client->strictRedirect()) {
                        $follow_method = $request->method();
                    } else {
                        $follow_method = Request::GET;
                    }
                    break;
            }

            // Prepare the additional request, copying any follow_headers that were present on the original request
            $orig_headers = $request->headers()->getArrayCopy();
            $follow_headers = array_intersect_assoc($orig_headers, array_fill_keys($client->followHeaders(), true));

            $follow_request = Request::factory($response->headers('Location'))
                    ->method($follow_method)
                    ->headers($follow_headers);

            if ($follow_method !== Request::GET) {
                $follow_request->body($request->body());
            }

            return $follow_request;
        }

        return null;
    }

}
