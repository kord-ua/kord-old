<?php

namespace KORD\Filtration\Word;

use KORD\UTF8;

class SeparatorToCamelCaseSrc extends WordFilterAbstract
{

    /**
     * Filter options
     *
     * @var array
     */
    protected $options = [
        'lowercase' => false,
        'search_separator' => null,
    ];

    /**
     * Sets if the string has to be lowercased before conversion to camelcase
     *
     * @param  bool $flag Use lowercased value?
     * @return $this
     */
    public function setLowercase($flag = true)
    {
        $this->options['lowercase'] = (bool) $flag;
        return $this;
    }

    /**
     * Returns true if the filtered path must exist
     *
     * @return bool
     */
    public function getLowercase()
    {
        return $this->options['lowercase'];
    }
    
    /**
     * Defined by \KORD\Filtration\FilterInterface
     *
     * @param  string|array $value
     * @return string|array
     */
    public function filter($value)
    {
        if (!is_scalar($value) AND !is_array($value)) {
            return $value;
        }

        // a unicode safe way of converting characters to \x00\x00 notation
        $preg_quoted_separator = preg_quote($this->getSearchSeparator(), '#');

        if (UTF8::unicodeEnabled()) {
            $patterns = [
                '#(' . $preg_quoted_separator.')(\p{L}{1}|\p{N}{1})#u',
                '#(^\p{Ll}{1})#u',
            ];
            if (!UTF8::mbstringEnabled()) {
                $replacements = [
                    function ($matches) {
                        return strtoupper($matches[2]);
                    },
                    function ($matches) {
                        return strtoupper($matches[1]);
                    },
                ];
            } else {
                $replacements = [
                    function ($matches) {
                        return mb_strtoupper($matches[2], 'UTF-8');
                    },
                    function ($matches) {
                        return mb_strtoupper($matches[1], 'UTF-8');
                    },
                ];
            }
        } else {
            $patterns = [
                '#(' . $preg_quoted_separator.')([A-Za-z]{1})#',
                '#(^[A-Za-z]{1})#',
            ];
            $replacements = [
                function ($matches) {
                    return strtoupper($matches[2]);
                },
                function ($matches) {
                    return strtoupper($matches[1]);
                },
            ];
        }

        $filtered = ($this->getLowercase() ? strtolower($value) : $value);
        foreach ($patterns as $index => $pattern) {
            $filtered = preg_replace_callback($pattern, $replacements[$index], $filtered);
        }
        return $filtered;
    }
    
}
