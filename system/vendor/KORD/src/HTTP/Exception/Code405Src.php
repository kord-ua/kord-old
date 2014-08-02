<?php

namespace KORD\HTTP\Exception;

class Code405Src extends \KORD\HTTP\Exception\Expected
{

    /**
     * @var   integer    HTTP 405 Method Not Allowed
     */
    protected $code = 405;

    /**
     * Specifies the list of allowed HTTP methods
     *
     * @param  array $methods List of allowed methods
     */
    public function allowed($methods)
    {
        if (is_array($methods)) {
            $methods = implode(',', $methods);
        }

        $this->headers('allow', $methods);

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
        if ($location = $this->headers('allow') === null) {
            throw new \KORD\Exception('A list of allowed methods must be specified');
        }
        
        return true;
    }

}
