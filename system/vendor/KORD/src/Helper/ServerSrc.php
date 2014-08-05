<?php

/**
 * Helps to handle $_SERVER superglobal array
 *
 * @copyright  (c) 2007–2014 Kohana Team
 */

namespace KORD\Helper;

class ServerSrc
{

    /**
     * @var  string  trusted proxy server IPs
     */
    public static $trusted_proxies = ['127.0.0.1', 'localhost', 'localhost.localdomain'];

    /**
     * Get Request method
     * 
     * @return string  Request method
     */
    public static function requestMethod()
    {
        return Arr::get($_SERVER, 'REQUEST_METHOD', 'GET');
    }

    /**
     * Is the Request secure?
     * 
     * @return bool 
     */
    public static function requestSecure()
    {
        return (!empty($_SERVER['HTTPS']) AND filter_var($_SERVER['HTTPS'], FILTER_VALIDATE_BOOLEAN))
                OR ( isset($_SERVER['HTTP_X_FORWARDED_PROTO'])
                AND $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
                AND in_array($_SERVER['REMOTE_ADDR'], Server::$trusted_proxies);
    }

    /**
     * Get HTTP Referrer
     * 
     * @return string HTTP Referrer
     */
    public static function httpReferrer()
    {
        return Arr::get($_SERVER, 'HTTP_REFERER', 'unknown');
    }

    /**
     * Returns information about the initial user agent.
     * 
     * @return string  HTTP User-Agent
     */
    public static function userAgent()
    {
        return Arr::get($_SERVER, 'HTTP_USER_AGENT', 'unknown');
    }

    /**
     * Typically used to denote AJAX requests
     * 
     * @return string
     */
    public static function requestedWith()
    {
        return Arr::get($_SERVER, 'HTTP_X_REQUESTED_WITH', 'unknown');
    }

    /**
     * Get client's IP address
     * 
     * @return string  IP address
     */
    public static function clientIp()
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])
                AND isset($_SERVER['REMOTE_ADDR'])
                AND in_array($_SERVER['REMOTE_ADDR'], Server::$trusted_proxies)) {
            // Use the forwarded IP address, typically set when the
            // client is using a proxy server.
            // Format: "X-Forwarded-For: client1, proxy1, proxy2"
            $client_ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

            return array_shift($client_ips);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])
                AND isset($_SERVER['REMOTE_ADDR'])
                AND in_array($_SERVER['REMOTE_ADDR'], Server::$trusted_proxies)) {
            // Use the forwarded IP address, typically set when the
            // client is using a proxy server.
            $client_ips = explode(',', $_SERVER['HTTP_CLIENT_IP']);

            return array_shift($client_ips);
        }
        
        return Arr::get($_SERVER, 'REMOTE_ADDR', '0.0.0.0');
    }
    
    /**
     * Automatically detects the URI of the main request using PATH_INFO,
     * REQUEST_URI, PHP_SELF or REDIRECT_URL.
     *
     *     $uri = Server::detectUri();
     *
     * @return  string  URI of the main request
     * @throws  \UnexpectedValueException
     */
    public static function detectUri()
    {
        if (!empty($_SERVER['PATH_INFO'])) {
            // PATH_INFO does not contain the docroot or index
            $uri = $_SERVER['PATH_INFO'];
        } else {
            // REQUEST_URI and PHP_SELF include the docroot and index

            if (isset($_SERVER['REQUEST_URI'])) {
                /**
                 * We use REQUEST_URI as the fallback value. The reason
                 * for this is we might have a malformed URL such as:
                 *
                 *  http://localhost/http://example.com/judge.php
                 *
                 * which parse_url can't handle. So rather than leave empty
                 * handed, we'll use this.
                 */
                $uri = $_SERVER['REQUEST_URI'];

                if ($request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) {
                    // Valid URL path found, set it.
                    $uri = $request_uri;
                }

                // Decode the request URI
                $uri = rawurldecode($uri);
            } elseif (isset($_SERVER['PHP_SELF'])) {
                $uri = $_SERVER['PHP_SELF'];
            } elseif (isset($_SERVER['REDIRECT_URL'])) {
                $uri = $_SERVER['REDIRECT_URL'];
            } else {
                // along with any relevant information about your web server setup. Thanks!
                throw new \UnexpectedValueException('Unable to detect the URI using PATH_INFO, REQUEST_URI, PHP_SELF or REDIRECT_URL');
            }

            // Get the path from the base URL, including the index file
            $base_url = parse_url(URL::$base_url, PHP_URL_PATH);

            if (strpos($uri, $base_url) === 0) {
                // Remove the base URL from the URI
                $uri = (string) substr($uri, strlen($base_url));
            }

            if (URL::$index_file AND strpos($uri, URL::$index_file) === 0) {
                // Remove the index file from the URI
                $uri = (string) substr($uri, strlen(URL::$index_file));
            }
        }

        return $uri;
    }

    /**
     * Determines if a file larger than the post_max_size has been uploaded. PHP
     * does not handle this situation gracefully on its own, so this method
     * helps to solve that problem.
     *
     * @return  boolean
     * @uses    Num::bytes
     * @uses    Arr::get
     */
    public static function postMaxSizeExceeded()
    {
        // Make sure the request method is POST
        if (Server::requestMethod() !== 'POST') {
            return false;
        }

        // Get the post_max_size in bytes
        $max_bytes = Num::bytes(ini_get('post_max_size'));

        // Error occurred if method is POST, and content length is too long
        return (Arr::get($_SERVER, 'CONTENT_LENGTH') > $max_bytes);
    }

}
