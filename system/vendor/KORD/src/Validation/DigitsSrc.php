<?php

namespace KORD\Validation;

class DigitsSrc extends RuleAbstract
{

    /**
     * Returns true if and only if $value only contains digit characters
     *
     * @param  string $value
     * @return bool
     */
    public function isValid($value)
    {
        if (!is_string($value) AND !is_int($value) AND !is_float($value)) {
            $this->addError('digitsInvalid');
            return false;
        }

        $filter = new \KORD\Filtration\Digits();

        if ((string) $value !== $filter->filter($value)) {
            $this->addError('notDigits');
            return false;
        }

        return true;
    }

}
