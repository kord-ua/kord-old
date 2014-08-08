<?php

namespace KORD\Request\Client;

use KORD\HTTP\Request as HTTPRequest;
use KORD\Request;
use KORD\Request\Exception as RequestException;
use KORD\Response;

/**
 * [\KORD\Request\Client\External] HTTP driver performs external requests using the
 * php-http extension. To use this driver, ensure the following is completed
 * before executing an external request- ideally in the application bootstrap.
 *
 * @example
 *
 *       // In application bootstrap
 *       \KORD\Request\Client\External::$client = '\KORD\Request\Client\HTTP';
 * @copyright  (c) 2007–2014 Kohana Team
 * @uses       [PECL HTTP](http://php.net/manual/en/book.http.php)
 */
class HTTPSrc extends \KORD\Request\Client\External
{

    /**
     * Creates a new `\KORD\Request\Client` object,
     * allows for dependency injection.
     *
     * @param   array    $params Params
     * @throws  \KORD\Exception
     */
    public function __construct(array $params = [])
    {
        // Check that PECL HTTP supports requests
        if (!http_support(HTTP_SUPPORT_REQUESTS)) {
            throw new RequestException('Need HTTP request support!');
        }

        // Carry on
        parent::__construct($params);
    }

    /**
     * @var     array     curl options
     * @link    http://www.php.net/manual/function.curl-setopt
     */
    protected $options = [];

    /**
     * Sends the HTTP message [\KORD\Request] to a remote server and processes
     * the response.
     *
     * @param   \KORD\Request   $request  request to send
     * @param   \KORD\Response  $response  response to send
     * @return  \KORD\Response
     */
    public function sendMessage(Request $request, Response $response)
    {
        $http_method_mapping = [
            HTTPRequest::GET => \HttpRequest::METH_GET,
            HTTPRequest::HEAD => \HttpRequest::METH_HEAD,
            HTTPRequest::POST => \HttpRequest::METH_POST,
            HTTPRequest::PUT => \HttpRequest::METH_PUT,
            HTTPRequest::DELETE => \HttpRequest::METH_DELETE,
            HTTPRequest::OPTIONS => \HttpRequest::METH_OPTIONS,
            HTTPRequest::TRACE => \HttpRequest::METH_TRACE,
            HTTPRequest::CONNECT => \HttpRequest::METH_CONNECT,
        ];

        // Create an http request object
        $http_request = new \HttpRequest($request->uri(), $http_method_mapping[$request->method()]);

        if ($this->options) {
            // Set custom options
            $http_request->setOptions($this->options);
        }

        // Set headers
        $http_request->setHeaders($request->headers()->getArrayCopy());

        // Set cookies
        $http_request->setCookies($request->cookie());

        // Set query data (?foo=bar&bar=foo)
        $http_request->setQueryData($request->query());

        // Set the body
        if ($request->method() == HTTPRequest::PUT) {
            $http_request->addPutData($request->body());
        } else {
            $http_request->setBody($request->body());
        }

        try {
            $http_request->send();
        } catch (\HttpRequestException $e) {
            throw new RequestException($e->getMessage());
        } catch (\HttpMalformedHeaderException $e) {
            throw new RequestException($e->getMessage());
        } catch (\HttpEncodingException $e) {
            throw new RequestException($e->getMessage());
        }

        // Build the response
        $response->status($http_request->getResponseCode())
                ->headers($http_request->getResponseHeader())
                ->cookie($http_request->getResponseCookies())
                ->body($http_request->getResponseBody());

        return $response;
    }

}
