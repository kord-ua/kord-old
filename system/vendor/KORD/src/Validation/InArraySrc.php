<?php

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace KORD\Validation;

use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use KORD\Validation\Exception;
use KORD\Validation\InArray;

class InArraySrc extends RuleAbstract
{
    // Type of Strict check
    /**
     * standard in_array strict checking value and type
     */
    const COMPARE_STRICT = 1;

    /**
     * Non strict check but prevents "asdf" == 0 returning TRUE causing false/positive.
     * This is the most secure option for non-strict checks and replaces strict = false
     * This will only be effective when the input is a string
     */
    const COMPARE_NOT_STRICT_SECURE = 0;

    /**
     * Standard non-strict check where "asdf" == 0 returns TRUE
     * This will be wanted when comparing "0" against int 0
     */
    const COMPARE_NOT_STRICT = -1;
    
    /**
     * Default options to set for the validator
     *
     * @var mixed
     */
    protected $options = [
        'haystack' => null,
        'strict' => InArray::COMPARE_NOT_STRICT_SECURE,
        'recursive' => false
    ];
    
    /**
     * Returns the haystack option
     *
     * @return mixed
     * @throws KORD\Validation\Exception if haystack option is not set
     */
    public function getHaystack()
    {
        if ($this->options['haystack'] === null) {
            throw new Exception('haystack option is mandatory');
        }
        return $this->options['haystack'];
    }

    /**
     * Sets the haystack option
     *
     * @param  mixed $haystack
     * @return $this Provides a fluent interface
     */
    public function setHaystack(array $haystack)
    {
        $this->options['haystack'] = $haystack;
        return $this;
    }

    /**
     * Returns the strict option
     *
     * @return bool|int
     */
    public function getStrict()
    {
        // To keep BC with new strict modes
        if ($this->options['strict'] == InArray::COMPARE_NOT_STRICT_SECURE
            OR $this->options['strict'] == InArray::COMPARE_STRICT
        ) {
            return (bool) $this->options['strict'];
        }
        return $this->options['strict'];
    }

    /**
     * Sets the strict option mode
     * InArray::CHECK_STRICT | InArray::CHECK_NOT_STRICT_SECURE | InArray::CHECK_NOT_STRICT
     *
     * @param  int $strict
     * @return $this Provides a fluent interface
     * @throws KORD\Validation\Exception
     */
    public function setStrict($strict)
    {
        $check_types = [
            InArray::COMPARE_NOT_STRICT_SECURE,    // 0
            InArray::COMPARE_STRICT,               // 1
            InArray::COMPARE_NOT_STRICT            // -1
        ];

        // validate strict value
        if (!in_array($strict, $check_types)) {
            throw new Exception('Strict option must be one of the COMPARE_ constants');
        }

        $this->options['strict'] = $strict;
        return $this;
    }

    /**
     * Returns the recursive option
     *
     * @return bool
     */
    public function getRecursive()
    {
        return $this->options['recursive'];
    }

    /**
     * Sets the recursive option
     *
     * @param  bool $recursive
     * @return $this Provides a fluent interface
     */
    public function setRecursive($recursive)
    {
        $this->options['recursive'] = (bool) $recursive;
        return $this;
    }

    /**
     * Returns true if and only if $value is contained in the haystack option. If the strict
     * option is true, then the type of $value is also checked.
     *
     * @param mixed $value
     * See {@link http://php.net/manual/function.in-array.php#104501}
     * @return bool
     */
    public function isValid($value)
    {
        // we create a copy of the haystack in case we need to modify it
        $haystack = $this->getHaystack();

        // if the input is a string or float, and vulnerability protection is on
        // we type cast the input to a string
        if (InArray::COMPARE_NOT_STRICT_SECURE == $this->getStrict()
            AND (is_int($value) OR is_float($value))) {
            $value = (string) $value;
        }

        if ($this->getRecursive()) {
            $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($haystack));
            foreach ($iterator as $element) {
                if (InArray::COMPARE_STRICT == $this->getStrict()) {

                    if ($element === $value) {
                        return true;
                    }

                } else {

                    // add protection to prevent string to int vuln's
                    $el = $element;
                    if (InArray::COMPARE_NOT_STRICT_SECURE == $this->getStrict()
                        AND is_string($value) AND (is_int($el) OR is_float($el))
                    ) {
                        $el = (string) $el;
                    }

                    if ($el == $value) {
                        return true;
                    }

                }
            }
        } else {

            /**
             * If the check is not strict, then, to prevent "asdf" being converted to 0
             * and returning a false positive if 0 is in haystack, we type cast
             * the haystack to strings. To prevent "56asdf" == 56 === TRUE we also
             * type cast values like 56 to strings as well.
             *
             * This occurs only if the input is a string and a haystack member is an int
             */
            if (InArray::COMPARE_NOT_STRICT_SECURE == $this->getStrict()
                AND is_string($value)
            ) {
                foreach ($haystack as &$h) {
                    if (is_int($h) OR is_float($h)) {
                        $h = (string) $h;
                    }
                }
            }

            if (in_array($value, $haystack, $this->getStrict() == InArray::COMPARE_STRICT ? true : false)) {
                return true;
            }
        }

        $this->addError('notInArray');
        return false;
    }
    
}
