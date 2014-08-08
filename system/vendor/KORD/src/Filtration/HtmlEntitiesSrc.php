<?php

namespace KORD\Filtration;

use KORD\Filtration\Exception;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */
class HtmlEntitiesSrc extends FilterAbstract
{

    /**
     * Filter options
     * 
     * @var array
     */
    protected $options = [
        'quote_style' => ENT_COMPAT,
        'encoding' => 'UTF-8',
        'double_quote' => true,
    ];

    /**
     * Returns the quote_style option
     *
     * @return integer
     */
    public function getQuoteStyle()
    {
        return $this->options['quote_style'];
    }

    /**
     * Sets the quote_style option
     *
     * @param  integer $quotestyle
     * @return $this Provides a fluent interface
     */
    public function setQuoteStyle($quotestyle)
    {
        $this->options['quote_style'] = $quotestyle;
        return $this;
    }

    /**
     * Get encoding
     *
     * @return string
     */
    public function getEncoding()
    {
        return $this->options['encoding'];
    }

    /**
     * Set encoding
     *
     * @param  string $value
     * @return $this
     */
    public function setEncoding($value)
    {
        $this->options['encoding'] = (string) $value;
        return $this;
    }

    /**
     * Returns the doubleQuote option
     *
     * @return boolean
     */
    public function getDoubleQuote()
    {
        return $this->options['double_quote'];
    }

    /**
     * Sets the doubleQuote option
     *
     * @param boolean $doublequote
     * @return $this Provides a fluent interface
     */
    public function setDoubleQuote($doublequote)
    {
        $this->options['double_quote'] = (boolean) $doublequote;
        return $this;
    }

    /**
     * Defined by \KORD\Filtration\FilterInterface
     *
     * Returns the string $value, converting characters to their corresponding HTML entity
     * equivalents where they exist
     *
     * @param  string $value
     * @return string
     */
    public function filter($value)
    {
        if (!is_scalar($value)) {
            return $value;
        }

        $value = (string) $value;

        $filtered = htmlentities($value, $this->getQuoteStyle(), $this->getEncoding(), $this->getDoubleQuote());
        if (strlen($value) AND ! strlen($filtered)) {
            if (!function_exists('iconv')) {
                throw new Exception('Encoding mismatch has resulted in htmlentities errors');
            }
            $enc = $this->getEncoding();
            $value = iconv('', $this->getEncoding() . '//IGNORE', $value);
            $filtered = htmlentities($value, $this->getQuoteStyle(), $enc, $this->getDoubleQuote());
            if (!strlen($filtered)) {
                throw new Exception('Encoding mismatch has resulted in htmlentities errors');
            }
        }
        return $filtered;
    }

}
