<?php

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace KORD\Filtration;

class IntSrc extends FilterAbstract
{

    /**
     * Defined by \KORD\Filtration\FilterInterface
     *
     * Returns (int) $value
     *
     * If the value provided is non-scalar, the value will remain unfiltered
     *
     * @param  string $value
     * @return int|mixed
     */
    public function filter($value)
    {
        if (!is_scalar($value)) {
            return $value;
        }

        return (int) ((string) $value);
    }

}
