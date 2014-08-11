<?php

namespace KORD\I18n\Plural;

/**
 * Common base for the plural rules with integer test.
 * 
 * @copyright  (c) 2012 Korney Czukowski
 * @copyright  (c) 2014 Andriy Strepetov
 * @license    MIT License
 */
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
