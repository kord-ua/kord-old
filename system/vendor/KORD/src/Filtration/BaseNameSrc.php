<?php

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace KORD\Filtration;

class BaseNameSrc extends FilterAbstract
{

    /**
     * Defined by \KORD\Filtration\FilterInterface
     *
     * Returns basename($value).
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

        return basename((string) $value);
    }

}
