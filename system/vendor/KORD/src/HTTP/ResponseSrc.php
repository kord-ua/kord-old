<?php

namespace KORD\HTTP;

/**
 * A HTTP Response specific interface that adds the methods required
 * by HTTP responses. Over and above [\KORD\HTTP\Interaction], this
 * interface provides status.
 * 
 * @copyright  (c) 2007–2014 Kohana Team
 * @copyright  (c) 2014 Andriy Strepetov
 */
interface ResponseSrc extends \KORD\HTTP\Message
{

    /**
     * Sets or gets the HTTP status from this response.
     *
     *      // Set the HTTP status to 404 Not Found
     *      $response = Response::factory()
     *              ->status(404);
     *
     *      // Get the current status
     *      $status = $response->status();
     *
     * @param   integer  $code  Status to set to this response
     * @return  mixed
     */
    public function status($code = null);
}
