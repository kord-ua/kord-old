<?php

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
