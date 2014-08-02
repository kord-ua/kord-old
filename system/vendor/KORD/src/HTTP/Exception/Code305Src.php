<?php

namespace KORD\HTTP\Exception;

class Code305Src extends \KORD\HTTP\Exception\Expected
{

    /**
     * @var   integer    HTTP 305 Use Proxy
     */
    protected $code = 305;

    /**
     * Specifies the proxy to replay this request via
     *
     * @param  string  $uri  URI of the proxy
     */
    public function location($uri = null)
    {
        if ($uri === null) {
            return $this->headers('Location');
        }

        $this->headers('Location', $uri);

        return $this;
    }

    /**
     * Validate this exception contains everything needed to continue.
     *
     * @throws \KORD\Exception
     * @return bool
     */
    public function check()
    {
        if ($location = $this->headers('location') === null) {
            throw new \KORD\Exception('A \'location\' must be specified for a redirect');
        }
            

        if (strpos($location, '://') === false) {
            throw new \KORD\Exception('An absolute URI to the proxy server must be specified');
        }

        return true;
    }

}
