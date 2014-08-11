<?php

namespace KORD\Filtration;

use KORD\Helper\UTF8;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @copyright  (c) 2014 Andriy Strepetov
 */
class StringToLowerSrc extends FilterAbstract
{

    /**
     * @var array
     */
    protected $options = [
        'encoding' => null,
    ];

    /**
     * Returns the set encoding
     *
     * @return string
     */
    public function getEncoding()
    {
        return $this->options['encoding'];
    }

    /**
     * Set the input encoding for the given string
     *
     * @param  string $encoding
     * @return $this Provides a fluent interface
     */
    public function setEncoding($encoding = null)
    {
        $this->options['encoding'] = $encoding;
        return $this;
    }

    /**
     * Defined by \KORD\Filtration\FilterInterface
     *
     * Returns the string $value, converting characters to lowercase as necessary
     * 
     * If the value provided is non-scalar, the value will remain unfiltered
     *
     * @param  string $value
     * @return string
     */
    public function filter($value)
    {
        if (!is_scalar($value)) {
            return $value;
        }
        
        return UTF8::strtolower((string) $value, $this->getEncoding());
    }

}
