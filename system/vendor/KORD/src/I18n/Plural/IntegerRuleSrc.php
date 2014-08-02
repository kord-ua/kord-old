<?php

/**
 * Common base for the plural rules with integer test.
 */

namespace KORD\I18n\Plural;

abstract class IntegerRuleSrc implements PluralInterface
{

    /**
     * Returns true if the value has only integer part and no decimal digits, regardless
     * of the actual type.
     * 
     * @param   mixed    $value
     * @return  boolean
     */
    protected function isInt($value)
    {
        return is_numeric($value) AND $value - intval($value) == 0;
    }

}
