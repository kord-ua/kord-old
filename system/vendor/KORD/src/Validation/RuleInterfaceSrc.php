<?php

namespace KORD\Validation;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @copyright  (c) 2014 Andriy Strepetov
 */
interface RuleInterfaceSrc
{

    /**
     * Returns true if and only if $value meets the validation requirements
     *
     * If $value fails validation, then this method returns false, and
     * getErrors() will return an array of error messages that explain why the
     * validation failed.
     *
     * @param  mixed $value
     * @return boolean
     */
    public function isValid($value);

    /**
     * Returns an array of error messages that explain why the most recent isValid()
     * call returned false. The array keys are validation failure message identifiers,
     * and the array values are the corresponding human-readable message strings.
     *
     * If isValid() was never called or if the most recent isValid() call
     * returned true, then this method returns an empty array.
     *
     * @return array
     */
    public function getErrors();
}
