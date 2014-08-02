<?php

namespace KORD\HTTP\Exception;

class Code300Src extends \KORD\HTTP\Exception\Redirect {

	/**
	 * @var   integer    HTTP 300 Multiple Choices
	 */
	protected $code = 300;

}
