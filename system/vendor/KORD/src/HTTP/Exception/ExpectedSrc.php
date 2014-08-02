<?php

/**
 * "Expected" HTTP exception class. Used for all [\KORD\HTTP\Exception]'s where
 * a standard KORD error page should never be shown.
 *
 * Eg [\KORD\HTTP\Exception\Code301], [\KORD\HTTP\Exception\Code302] etc
 */

namespace KORD\HTTP\Exception;

use KORD\Response;

abstract class ExpectedSrc extends \KORD\HTTP\Exception
{

    /**
     * @var  \KORD\Response   Response Object
     */
    protected $response;

    /**
     * Creates a new translated exception.
     *
     *     throw new \KORD\Exception('Something went terrible wrong, {user}',
     *         ['user' => $user]);
     *
     * @param   string  $message    status message, custom content to display with error
     * @param   array   $variables  translation variables
     * @return  void
     */
    public function __construct($message = null, array $variables = null, \Exception $previous = null)
    {
        parent::__construct($message, $variables, $previous);

        // Prepare our response object and set the correct status code.
        $this->response = (new Response)->status($this->code);
    }

    /**
     * Gets and sets headers to the [Response].
     *
     * @see     [Response::headers]
     * @param   mixed   $key
     * @param   string  $value
     * @return  mixed
     */
    public function headers($key = null, $value = null)
    {
        $result = $this->response->headers($key, $value);

        if (!$result instanceof Response) {
            return $result;
        }

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
        return true;
    }

    /**
     * Generate a Response for the current Exception
     *
     * @uses   \KORD\Exception::response()
     * @return \KORD\Response
     */
    public function getResponse()
    {
        $this->check();

        return $this->response;
    }

}
