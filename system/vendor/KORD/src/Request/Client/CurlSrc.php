<?php

/**
 * [\KORD\Request\Client\External] Curl driver performs external requests using the
 * php-curl extention. This is the default driver for all external requests.
 *
 */

namespace KORD\Request\Client;

use KORD\Exception;
use KORD\Request;
use KORD\Response;

class CurlSrc extends \KORD\Request\Client\External
{

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
        // Response headers
        $response_headers = [];

        $options = [];

        // Set the request method
        $options = $this->setCurlRequestMethod($request, $options);

        // Set the request body. This is perfectly legal in CURL even
        // if using a request other than POST. PUT does support this method
        // and DOES NOT require writing data to disk before putting it, if
        // reading the PHP docs you may have got that impression. SdF
        $options[CURLOPT_POSTFIELDS] = $request->body();

        // Process headers
        if ($headers = $request->headers()) {
            $http_headers = [];

            foreach ($headers as $key => $value) {
                $http_headers[] = $key . ': ' . $value;
            }

            $options[CURLOPT_HTTPHEADER] = $http_headers;
        }

        // Process cookies
        if ($cookies = $request->cookie()) {
            $options[CURLOPT_COOKIE] = http_build_query($cookies, null, '; ');
        }

        // Get any exisiting response headers
        $response_header = $response->headers();

        // Implement the standard parsing parameters
        $options[CURLOPT_HEADERFUNCTION] = [$response_header, 'parse_header_string'];
        $this->options[CURLOPT_RETURNTRANSFER] = true;
        $this->options[CURLOPT_HEADER] = false;

        // Apply any additional options set to
        $options += $this->options;

        $uri = $request->uri();

        if ($query = $request->query()) {
            $uri .= '?' . http_build_query($query, null, '&');
        }

        // Open a new remote connection
        $curl = curl_init($uri);

        // Set connection options
        if (!curl_setopt_array($curl, $options)) {
            throw new Exception('Failed to set CURL options, check CURL documentation: {url}', ['url' => 'http://php.net/curl_setopt_array']);
        }

        // Get the response body
        $body = curl_exec($curl);

        // Get the response information
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($body === false) {
            $error = curl_error($curl);
        }

        // Close the connection
        curl_close($curl);

        if (isset($error)) {
            throw new Exception('Error fetching remote {url} [ status {code} ] {error}', [
                'url' => $request->url(), 
                'code' => $code, 
                'error' => $error
            ]);
        }

        $response->status($code)
                ->body($body);

        return $response;
    }

    /**
     * Sets the appropriate curl request options. Uses the responding option
     * for POST or CURLOPT_CUSTOMREQUEST otherwise
     *
     * @param \KORD\Request $request
     * @param array $options
     * @return array
     */
    public function setCurlRequestMethod(Request $request, array $options)
    {
        switch ($request->method()) {
            case Request::POST:
                $options[CURLOPT_POST] = true;
                break;
            default:
                $options[CURLOPT_CUSTOMREQUEST] = $request->method();
                break;
        }
        return $options;
    }

}
