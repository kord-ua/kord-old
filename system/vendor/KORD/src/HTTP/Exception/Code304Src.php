<?php

namespace KORD\HTTP\Exception;

class Code304Src extends \KORD\HTTP\Exception\Expected
{

    /**
     * @var   integer    HTTP 304 Not Modified
     */
    protected $code = 304;

}
