<?php

namespace KORD\HTTP\Exception;

class Code303Src extends \KORD\HTTP\Exception\Redirect
{

    /**
     * @var   integer    HTTP 303 See Other
     */
    protected $code = 303;

}
