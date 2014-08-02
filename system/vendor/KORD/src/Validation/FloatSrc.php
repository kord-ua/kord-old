<?php

namespace KORD\Validation;

use KORD\Validation\Exception;

class FloatSrc extends RuleAbstract
{
    /**
     * Default options to set for the validator
     *
     * @var mixed
     */
    protected $options = [
        'decimal_separators' => ['.', ','],
        'decimals' => null,
        'group_separators' => [''],
        'group_size' => 3
    ];
    
    /**
     * Returns the decimal_separators option
     *
     * @return array
     */
    public function getDecimalSeparators()
    {
        return $this->options['decimal_separators'];
    }

    /**
     * Sets the decimal_separators option
     *
     * Decimal separators should be string or not empty array of strings
     *
     * @param  string|array $separators
     * @throws \KORD\Validation\Exception
     * @return $this provides a fluent interface
     */
    public function setDecimalSeparators($separators)
    {
        if (!is_string($separators) AND !is_array($separators)) {
            throw new Exception('Decimal separators should be string or array of strings');
        }
        
        if (!is_array($separators)) {
            $separators = [$separators];
        } elseif (empty($separators)) {
            throw new Exception('Decimal separators array should not be empty');
        }
        
        $this->options['decimal_separators'] = $separators;
        
        return $this;
    }
    
    /**
     * Returns the decimals option
     *
     * @return int|null
     */
    public function getDecimals()
    {
        return $this->options['decimals'];
    }

    /**
     * Sets the decimals option
     *
     * Decimals count should be integer or null
     *
     * @param  int|null $count
     * @throws \KORD\Validation\Exception
     * @return $this provides a fluent interface
     */
    public function setDecimals($count)
    {
        if (!is_int($count) AND $count !== null) {
            throw new Exception('Decimals count should be integer or null');
        }
        
        $this->options['decimals'] = $count;
        
        return $this;
    }
    
    /**
     * Returns the group_separators option
     *
     * @return array
     */
    public function getGroupSeparators()
    {
        return $this->options['group_separators'];
    }

    /**
     * Sets the group_separators option
     *
     * Group separators should be string or not empty array of strings
     *
     * @param  string|array $separators
     * @throws \KORD\Validation\Exception
     * @return $this provides a fluent interface
     */
    public function setGroupSeparators($separators)
    {
        if (!is_string($separators) AND !is_array($separators)) {
            throw new Exception('Group separators should be string or array of strings');
        }
        
        if (!is_array($separators)) {
            $separators = [$separators];
        } elseif (empty($separators)) {
            throw new Exception('Group separators array should not be empty');
        }
        
        $this->options['group_separators'] = $separators;
        
        return $this;
    }
    
    /**
     * Returns the group_size option
     *
     * @return int
     */
    public function getGroupSize()
    {
        return $this->options['group_size'];
    }

    /**
     * Sets the group_size option
     *
     * Digits group size should be integer greater than 0
     *
     * @param  int $size
     * @throws \KORD\Validation\Exception
     * @return $this provides a fluent interface
     */
    public function setGroupSize($size)
    {
        if (!is_int($size) AND $size < 1) {
            throw new Exception('Digits group size should be integer greater than 0');
        }
        
        $this->options['group_size'] = $size;
        
        return $this;
    }
    
    /**
     * Returns true if and only if $value is int, float or string containing float
     *
     * @param  string $value
     * @return bool
     */
    public function isValid($value)
    {
        // return true if value is integer
        if (is_int($value)) {
            return true;
        }
        
        if (!is_string($value) AND !is_float($value)) {
            $this->addError('floatInvalid');
            return false;
        }
        
        $is_float = false;
        $value = (is_numeric($value) ? floatval($value) : $value);
        foreach ($this->getDecimalSeparators() as $decimal_separator) {
            foreach ($this->getGroupSeparators() as $group_separator) {
                $decimals = ($this->getDecimals() === null ? '' : (string) $this->getDecimals());
                $group_separator = ($group_separator == '' ? '' : '\\'.$group_separator);
                if ($decimal_separator != $group_separator 
                        AND preg_match('/^\-?[0-9]{1,'.$this->getGroupSize().'}('.$group_separator.'[0-9]{'.$this->getGroupSize().'})*(\\'.$decimal_separator.'([0-9]{0,'.$decimals.'}))?$/', (string) $value)) {
                    $is_float = true;
                }
            }
        }
        
        if (!$is_float) {
            $this->addError('notFloat');
            return false;
        }

        return true;
    }
    
}
