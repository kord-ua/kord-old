<?php

namespace KORD\Request\Client;

use KORD\HTTP\Request as HTTPRequest;
use KORD\Request;
use KORD\Response;

/**
 * [\KORD\Request\Client] Stream driver performs external requests using php
 * sockets. To use this driver, ensure the following is completed
 * before executing an external request- ideally in the application bootstrap.
 *
 * @example
 *
 *       // In application bootstrap
 *       \KORD\Request\Client\External::$client = '\KORD\Request\Client\Stream';
 *
 * @copyright  (c) 2007–2014 Kohana Team
 * @copyright  (c) 2014 Andriy Strepetov
 * @uses       [PHP Streams](http://php.net/manual/en/book.stream.php)
 */
class StreamSrc extends \KORD\Request\Client\External
{

    /**
     * Sends the HTTP message [\KORD\Request] to a remote server and processes
     * the response.
     *
     * @param   \KORD\Request   $request  request to send
     * @param   \KORD\Response  $response  response to send
     * @return  \KORD\Response
     * @uses    [PHP cURL](http://php.net/manual/en/book.curl.php)
     */
    public function sendMessage(Request $request, Response $response)
    {
        // Calculate stream mode
        $mode = ($request->method() === HTTPRequest::GET) ? 'r' : 'r+';

        // Process cookies
        if ($cookies = $request->cookie()) {
            $request->headers('cookie', http_build_query($cookies, null, '; '));
        }

        // Get the message body
        $body = $request->body();

        if (is_resource($body)) {
            $body = stream_get_contents($body);
        }

        // Set the content length
        $request->headers('content-length', (string) strlen($body));

        list($protocol) = explode('/', $request->protocol());

        // Create the context
        $options = [
            strtolower($protocol) => [
                'method' => $request->method(),
                'header' => (string) $request->headers(),
                'content' => $body
            ]
        ];

        // Create the context stream
        $context = stream_context_create($options);

        stream_context_set_option($context, $this->options);

        $uri = $request->uri();

        if ($query = $request->query()) {
            $uri .= '?' . http_build_query($query, null, '&');
        }

        $stream = fopen($uri, $mode, false, $context);

        $meta_data = stream_get_meta_data($stream);

        // Get the HTTP response code
        $http_response = array_shift($meta_data['wrapper_data']);

        if (preg_match_all('/(\w+\/\d\.\d) (\d{3})/', $http_response, $matches) !== false) {
            $protocol = $matches[1][0];
            $status = (int) $matches[2][0];
        } else {
            $protocol = null;
            $status = null;
        }

        // Get any exisiting response headers
        $response_header = $response->headers();

        // Process headers
        array_map([$response_header, 'parse_header_string'], [], $meta_data['wrapper_data']);

        $response->status($status)
                ->protocol($protocol)
                ->body(stream_get_contents($stream));

        // Close the stream after use
        fclose($stream);

        return $response;
    }

}
