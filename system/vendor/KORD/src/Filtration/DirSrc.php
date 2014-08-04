<?php

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace KORD\Filtration;

class DirSrc extends FilterAbstract
{
    /**
     * Defined by \KORD\Filtration\FilterInterface
     *
     * Returns dirname($value)
     *
     * @param  string $value
     * @return string
     */
    public function filter($value)
    {
        if (!is_scalar($value)) {
            return $value;
        }
        
        return dirname((string) $value);
    }
}
