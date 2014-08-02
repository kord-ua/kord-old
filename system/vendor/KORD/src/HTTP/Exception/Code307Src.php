<?php

namespace KORD\HTTP\Exception;

class Code307Src extends \KORD\HTTP\Exception\Redirect
{

    /**
     * @var   integer    HTTP 307 Temporary Redirect
     */
    protected $code = 307;

}
