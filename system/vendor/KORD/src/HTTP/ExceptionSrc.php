<?php

namespace KORD\HTTP;

use KORD\Exception;
use KORD\Request as KRequest;

abstract class ExceptionSrc extends Exception {

	/**
	 * Creates an \KORD\HTTP\Exception of the specified type.
	 *
	 * @param   integer $code       the http status code
	 * @param   string  $message    status message, custom content to display with error
	 * @param   array   $variables  translation variables
	 * @return  \KORD\HTTP\Exception
	 */
	public static function factory($code, $message = null, array $variables = null, \Exception $previous = null)
	{
		$class = '\KORD\HTTP\Exception\Code'.$code;

		return new $class($message, $variables, $previous);
	}

	/**
	 * @var  int        http status code
	 */
	protected $code = 0;

	/**
	 * @var  \KORD\Request    Request instance that triggered this exception.
	 */
	protected $request;

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
		parent::__construct($message, $variables, $this->code, $previous);
	}

	/**
	 * Store the Request that triggered this exception.
	 *
	 * @param   \KORD\Request   $request  Request object that triggered this exception.
	 * @return  \KORD\HTTP\Exception
	 */
	public function request(KRequest $request = null)
	{
		if ($request === null) {
                    return $this->request;
                }

		$this->request = $request;

		return $this;
	}

	/**
	 * Generate a Response for the current Exception
	 *
	 * @uses   \KORD\Exception::response()
	 * @return \KORD\Response
	 */
	public function getResponse()
	{
		return Exception::response($this);
	}

}
