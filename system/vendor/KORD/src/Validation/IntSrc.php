<?php

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace KORD\Validation;

use KORD\Validation\Exception;

class IntSrc extends RuleAbstract
{

    /**
     * Default options to set for the validator
     *
     * @var mixed
     */
    protected $options = [
        'group_separators' => [''],
        'group_size' => 3
    ];

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
        if (!is_string($separators) AND ! is_array($separators)) {
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
     * Returns true if and only if $value is integer or string containing integer
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

        if (!is_string($value)) {
            $this->addError('intInvalid');
            return false;
        }

        $is_int = false;
        $value = (is_numeric($value) ? floatval($value) : $value);
        foreach ($this->getGroupSeparators() as $group_separator) {
            $group_separator = ($group_separator == '' ? '' : '\\' . $group_separator);
            if (preg_match('/^\-?[0-9]{1,' . $this->getGroupSize() . '}(' . $group_separator . '[0-9]{' . $this->getGroupSize() . '})*$/', (string) $value)) {
                $is_int = true;
            }
        }

        if (!$is_int) {
            $this->addError('notInt');
            return false;
        }

        return true;
    }

}
