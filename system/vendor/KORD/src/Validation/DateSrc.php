<?php

namespace KORD\Validation;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */
class DateSrc extends RuleAbstract
{
    
    /**
     * Default options to set for the validator
     *
     * @var mixed
     */
    protected $options = [
        'format' => 'Y-m-d', // Default format
    ];

    /**
     * Returns the format option
     *
     * @return string|null
     */
    public function getFormat()
    {
        return $this->options['format'];
    }

    /**
     * Sets the format option
     *
     * Format cannot be null.  It will always default to 'Y-m-d', even
     * if null is provided.
     *
     * @param  string $format
     * @return $this provides a fluent interface
     * @todo   validate the format
     */
    public function setFormat($format)
    {
        if (!empty($format) AND is_string($format)) {
            $this->options['format'] = $format;
        }
        
        return $this;
    }

    /**
     * Returns true if $value is a DateTime instance or can be converted into one.
     *
     * @param  string|array|int|DateTime $value
     * @return bool
     */
    public function isValid($value)
    {
        if ($value instanceof \DateTime) {
            return true;
        }
        
        $type = gettype($value);
        if (!in_array($type, ['string', 'integer', 'array'])) {
            $this->addError('dateInvalid');
            return false;
        }
        
        $convertMethod = 'convert' . ucfirst($type);
        
        if (!$this->{$convertMethod}($value)) {
            $this->addError('dateInvalidDate');
            return false;
        }

        return true;
    }

    /**
     * Attempts to convert an integer into a DateTime object
     *
     * @param  integer $value
     * @return bool|DateTime
     */
    protected function convertInteger($value)
    {
        return date_create("@$value");
    }

    /**
     * Attempts to convert a string into a DateTime object
     *
     * @param  string $value
     * @return bool|DateTime
     */
    protected function convertString($value)
    {
        $date = \DateTime::createFromFormat($this->getFormat(), $value);

        // Invalid dates can show up as warnings (ie. "2007-02-99")
        // and still return a DateTime object.
        $errors = \DateTime::getLastErrors();
        if ($errors['warning_count'] > 0) {
            $this->addError('dateFalseFormat', [':format' => $this->getFormat()]);
            return false;
        }

        return $date;
    }

    /**
     * Implodes the array into a string and proxies to {@link convertString()}.
     *
     * @param  array $value
     * @return bool|DateTime
     * @todo   enhance the implosion
     */
    protected function convertArray(array $value)
    {
        return $this->convertString(implode('-', $value));
    }

}
