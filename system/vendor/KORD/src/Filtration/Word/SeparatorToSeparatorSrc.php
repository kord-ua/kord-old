<?php

namespace KORD\Filtration\Word;

class SeparatorToSeparatorSrc extends WordFilterAbstract
{

    /**
     * Defined by \KORD\Filtration\FilterInterface
     *
     * Returns the string $value, replacing the searched separators with the defined ones
     *
     * @param  string|array $value
     * @return string|array
     */
    public function filter($value)
    {
        if (!is_scalar($value) AND !is_array($value)) {
            return $value;
        }

        $pattern = '#' . preg_quote($this->getSearchSeparator(), '#') . '#';
        return preg_replace($pattern, $this->getReplacementSeparator(), $value);
    }
}
