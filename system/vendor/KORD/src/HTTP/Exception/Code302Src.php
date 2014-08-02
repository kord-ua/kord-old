<?php

namespace KORD\HTTP\Exception;

class Code302Src extends \KORD\HTTP\Exception\Redirect
{

    /**
     * @var   integer    HTTP 302 Found
     */
    protected $code = 302;

}
