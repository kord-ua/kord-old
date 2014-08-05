<?php

/**
 * Redirect HTTP exception class. Used for all [\KORD\HTTP\Exception]'s where the status
 * code indicates a redirect.
 *
 * Eg [\KORD\HTTP\Exception\Code301], [\KORD\HTTP\Exception\Code302] and most of the other 30x's
 */

namespace KORD\HTTP\Exception;

use KORD\Exception;
use KORD\Helper\URL;

abstract class RedirectSrc extends \KORD\HTTP\Exception\Expected
{

    /**
     * Specifies the URI to redirect to.
     *
     * @param  string  $uri  URI of the proxy
     */
    public function location($uri = null)
    {
        if ($uri === null) {
            return $this->headers('Location');
        }

        if (strpos($uri, '://') === false) {
            // Make the URI into a URL
            $uri = URL::site($uri, true, !empty(URL::$index_file));
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
        if ($this->headers('location') === null) {
            throw new Exception('A \'location\' must be specified for a redirect');
        }

        return true;
    }

}
