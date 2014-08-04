<?php

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace KORD\Filtration\Word;

use KORD\UTF8;

class CamelCaseToSeparatorSrc extends WordFilterAbstract
{
    /**
     * Filter options
     *
     * @var array
     */
    protected $options = [
        'lowercase' => false,
        'replacement_separator' => null,
    ];
    
    /**
     * Sets a lowercase option
     *
     * @param  bool $flag
     * @return $this
     */
    public function setLowercase($flag)
    {
        $this->options['lowercase'] = (bool) $flag;
        return $this;
    }

    /**
     * Returns the actual set lowercase option
     *
     * @return string
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
        
        $separator = $this->getReplacementSeparator();
        
        if (UTF8::unicodeEnabled()) {
            $pattern     = ['#(?<=(?:\p{Lu}))(\p{Lu}\p{Ll})#', '#(?<=(?:\p{Ll}|\p{Nd}))(\p{Lu})#'];
            $replacement = [$separator . '\1', $separator . '\1'];
        } else {
            $pattern     = ['#(?<=(?:[A-Z]))([A-Z]+)([A-Z][a-z])#', '#(?<=(?:[a-z0-9]))([A-Z])#'];
            $replacement = ['\1' . $separator . '\2', $separator . '\1'];
        }
        
        $value = preg_replace($pattern, $replacement, $value);

        if ($this->getLowercase()) {
            return strtolower($value);
        }
        
        return $value;
    }
}
