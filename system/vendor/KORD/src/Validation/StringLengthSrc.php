<?php

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace KORD\Validation;

use KORD\Helper\UTF8;
use KORD\Validation\Exception;

class StringLengthSrc extends RuleAbstract
{

    /**
     * Default options to set for the validator
     *
     * @var mixed
     */
    protected $options = [
        'min' => 0, // Minimum length
        'max' => null, // Maximum length, null if there is no length limitation
        'lengths' => [], // Allowed lengths within min...max range, empty if any
        'encoding' => 'UTF-8', // Encoding to use
    ];
    
    /**
     * Returns the min option
     *
     * @return int
     */
    public function getMin()
    {
        return $this->options['min'];
    }

    /**
     * Sets the min option
     *
     * @param  int $min
     * @throws \KORD\Validation\Exception
     * @return $this Provides a fluent interface
     */
    public function setMin($min)
    {
        if (null !== $this->getMax() AND $min > $this->getMax()) {
            throw new Exception("The minimum must be less than or equal to the maximum length, but $min > " . $this->getMax());
        }

        $this->options['min'] = max(0, (int) $min);
        return $this;
    }

    /**
     * Returns the max option
     *
     * @return int|null
     */
    public function getMax()
    {
        return $this->options['max'];
    }

    /**
     * Sets the max option
     *
     * @param  int|null $max
     * @throws \KORD\Validation\Exception
     * @return $this Provides a fluent interface
     */
    public function setMax($max)
    {
        if (null === $max) {
            $this->options['max'] = null;
        } elseif ($max < $this->getMin()) {
            throw new Exception("The maximum must be greater than or equal to the minimum length, but $max < " . $this->getMin());
        } else {
            $this->options['max'] = (int) $max;
        }

        return $this;
    }
    
    /**
     * Returns the lengths option
     *
     * @return array
     */
    public function getLengths()
    {
        return $this->options['lengths'];
    }

    /**
     * Sets the lengths option
     *
     * @param  int|array $lengths
     * @throws \KORD\Validation\Exception
     * @return $this Provides a fluent interface
     */
    public function setLengths($lengths)
    {
        if (!is_array($lengths)) {
            $lengths = [$lengths];
        }
        
        foreach ($lengths as $length) {
            if (!is_int($length)) {
                throw new Exception("The allowed string length should be integer or array of integers");
            }
        }
        
        $this->options['lengths'] = $lengths;

        return $this;
    }
    
    /**
     * Returns the actual encoding
     *
     * @return string
     */
    public function getEncoding()
    {
        return $this->options['encoding'];
    }

    /**
     * Sets a new encoding to use
     *
     * @param string $encoding
     * @return $this
     * @throws \KORD\Validation\Exception
     */
    public function setEncoding($encoding)
    {
        $this->options['encoding'] = $encoding;
        return $this;
    }

    /**
     * Returns true if and only if the string length of $value is at least the min option and
     * no greater than the max option (when the max option is not null).
     *
     * @param  string $value
     * @return bool
     */
    public function isValid($value)
    {
        if (!is_string($value)) {
            $this->addError('stringLengthInvalid');
            return false;
        }
        
        $length = UTF8::strlen($value, $this->getEncoding());
        
        if (in_array($length, $this->getLengths())) {
            return true;
        }
        
        if ($length < $this->getMin()) {
            $this->addError('stringLengthTooShort', [':min' => $this->getMin()]);
            return false;
        }

        if (null !== $this->getMax() AND $this->getMax() < $length) {
            $this->addError('stringLengthTooLong', [':max' => $this->getMax()]);
            return false;
        }

        return true;
    }

}
