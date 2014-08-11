<?php

namespace KORD\Filtration;

use KORD\Helper\UTF8;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @copyright  (c) 2014 Andriy Strepetov
 */
class DigitsSrc extends FilterAbstract
{
    
    /**
     * Defined by \KORD\Filtration\FilterInterface
     *
     * Returns the string $value, removing all but digit characters
     *
     * If the value provided is non-scalar, the value will remain unfiltered
     *
     * @param  string $value
     * @return string|mixed
     */
    public function filter($value)
    {
        if (!is_scalar($value)) {
            return $value;
        }

        if (!UTF8::unicodeEnabled()) {
            // POSIX named classes are not supported, use alternative 0-9 match
            $pattern = '/[^0-9]/';
        } elseif (UTF8::mbstringEnabled()) {
            // Filter for the value with mbstring
            $pattern = '/[^[:digit:]]/';
        } else {
            // Filter for the value without mbstring
            $pattern = '/[\p{^N}]/';
        }

        return preg_replace($pattern, '', (string) $value);
    }

}
