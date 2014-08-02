<?php

namespace KORD\HTTP\Exception;

class Code301Src extends \KORD\HTTP\Exception\Redirect
{

    /**
     * @var   integer    HTTP 301 Moved Permanently
     */
    protected $code = 301;

}
