<?php

namespace KORD\Validation;

use KORD\Security\CSRF as SecurityCSRF;

/**
 * @copyright  (c) 2014 Andriy Strepetov
 */
class CSRFSrc extends RuleAbstract
{

    /**
     * Options for this validator
     *
     * @var array
     */
    protected $options = [];

    /**
     * Returns true if and only if $value is a valid existing CSRF token
     *
     * @param  string $value
     * @return bool
     */
    public function isValid($value)
    {
        if (!is_string($value)) {
            $this->addError('csrfInvalid');
            return false;
        }

        if (!SecurityCSRF::checkToken($value)) {
            $this->addError('csrfInvalidToken');
            return false;
        }
        
        SecurityCSRF::deleteToken($value);

        return true;
    }

}
