<?php

/**
 * Request Client for internal execution
 * 
 * @copyright  (c) 2007–2014 Kohana Team
 */

namespace KORD\Request\Client;

use KORD\Core;
use KORD\Exception;
use KORD\HTTP\Exception as HTTPException;
use KORD\Profiler;
use KORD\Request;
use KORD\Response;

class InternalSrc extends \KORD\Request\Client
{

    /**
     * @var    array
     */
    protected $previous_environment;

    /**
     * Processes the request, executing the controller action that handles this
     * request, determined by the [\KORD\Route].
     *
     *     $request->execute();
     *
     * @param   \KORD\Request $request
     * @return  \KORD\Response
     * @throws  \KORD\HTTP\Exception
     * @throws  \KORD\Exception
     * @uses    [\KORD\Core::$profiling]
     * @uses    [\KORD\Profiler]
     */
    public function executeRequest(Request $request, Response $response)
    {
        // Create the class suffix
        $suffix = 'Controller';

        // Namespace
        $namespace = $request->getNamespace(true);

        // Controller
        $controller = $request->controller();

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

        // Store the currently active request
        $previous = Request::current();

        // Change the current request to this request
        Request::current($request);

        // Is this the initial request
        $initial_request = ($request === Request::initial());

        try {
            if (!class_exists($namespace . $controller . $suffix)) {
                throw HTTPException::factory(404, 'The requested URL {uri} was not found on this server.', ['uri' => $request->uri()]
                )->request($request);
            }

            // Load the controller using reflection
            $class = new \ReflectionClass($namespace . $controller . $suffix);

            if ($class->isAbstract()) {
                throw new Exception(
                'Cannot create instances of abstract {controller}', [
                    'controller' => $namespace . $controller . $suffix
                ]
                );
            }

            // Create a new instance of the controller
            $controller_instance = $class->newInstance($request, $response);

            // Run the controller's execute() method
            $response = $class->getMethod('execute')->invoke($controller_instance);

            if (!$response instanceof Response) {
                // Controller failed to return a Response.
                throw new Exception('Controller failed to return a Response');
            }
        } catch (HTTPException $e) {
            // Store the request context in the Exception
            if ($e->request() === null) {
                $e->request($request);
            }

            // Get the response via the Exception
            $response = $e->getResponse();
        } catch (Exception $e) {
            // Generate an appropriate Response object
            $response = Exception::handle($e);
        }

        // Restore the previous request
        if (!$initial_request) {
            Request::current($previous);
        }

        if (isset($benchmark)) {
            // Stop the benchmark
            Profiler::stop($benchmark);
        }

        // Return the response
        return $response;
    }

}
