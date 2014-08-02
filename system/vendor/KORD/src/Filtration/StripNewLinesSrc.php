<?php

namespace KORD\Filtration;

class StripNewLinesSrc extends FilterAbstract
{

    /**
     * Defined by \KORD\Filtration\FilterInterface
     *
     * Returns $value without newline control characters
     *
     * @param  string|array $value
     * @return string|array
     */
    public function filter($value)
    {
        if (!is_scalar($value) AND ! is_array($value)) {
            return $value;
        }
        return str_replace(["\n", "\r"], '', $value);
    }

}
