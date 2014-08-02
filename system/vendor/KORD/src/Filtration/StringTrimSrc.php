<?php

namespace KORD\Filtration;

use KORD\UTF8;

class StringTrimSrc extends FilterAbstract
{

    /**
     * @var array
     */
    protected $options = [
        'char_list' => null,
    ];

    /**
     * Sets the charlist option
     *
     * @param  string $charlist
     * @return $this Provides a fluent interface
     */
    public function setCharList($charlist)
    {
        if (empty($charlist)) {
            $charlist = null;
        }
        $this->options['char_list'] = $charlist;
        return $this;
    }

    /**
     * Returns the charlist option
     *
     * @return string|null
     */
    public function getCharList()
    {
        return $this->options['char_list'];
    }

    /**
     * Defined by \KORD\Filtration\FilterInterface
     *
     * Returns the string $value with characters stripped from the beginning and end
     *
     * @param  string $value
     * @return string
     */
    public function filter($value)
    {
        if (!is_string($value)) {
            return $value;
        }
        
        return UTF8::trim((string) $value, $this->getCharList());
    }

}
