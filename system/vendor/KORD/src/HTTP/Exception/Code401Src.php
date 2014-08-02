<?php

namespace KORD\HTTP\Exception;

class Code401Src extends \KORD\HTTP\Exception\Expected
{

    /**
     * @var   integer    HTTP 401 Unauthorized
     */
    protected $code = 401;

    /**
     * Specifies the WWW-Authenticate challenge.
     *
     * @param  string  $challenge  WWW-Authenticate challenge (eg `Basic realm="Control Panel"`)
     */
    public function authenticate($challenge = null)
    {
        if ($challenge === null) {
            return $this->headers('www-authenticate');
        }

        $this->headers('www-authenticate', $challenge);

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
        if ($this->headers('www-authenticate') === null) {
            throw new \KORD\Exception('A \'www-authenticate\' header must be specified for a HTTP 401 Unauthorized');
        }
        
        return true;
    }

}
