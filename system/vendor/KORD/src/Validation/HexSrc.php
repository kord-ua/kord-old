<?php

namespace KORD\Validation;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @copyright  (c) 2014 Andriy Strepetov
 */
class HexSrc extends RuleAbstract
{

    /**
     * Returns true if and only if $value contains only hexadecimal digit characters
     *
     * @param  string $value
     * @return bool
     */
    public function isValid($value)
    {
        if (!is_string($value) AND !is_int($value)) {
            $this->addError('hexInvalid');
            return false;
        }
        
        if (!ctype_xdigit((string) $value)) {
            $this->addError('notHex');
            return false;
        }

        return true;
    }

}
