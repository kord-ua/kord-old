<?php

namespace KORD\I18n\Plural;

/**
 * Plural rules for Tachelhit language:
 * 
 * Locales: shi
 * 
 * Languages:
 * - Tachelhit (shi)
 * 
 * Rules:
 * 	one → n within 0..1;
 * 	few → n in 2..10;
 * 	other → everything else
 * 
 * Reference CLDR Version 21 (2012-03-01 03:27:30 GMT)
 * @see  http://unicode.org/repos/cldr-tmp/trunk/diff/supplemental/language_plural_rules.html
 * @see  http://unicode.org/repos/cldr/trunk/common/supplemental/plurals.xml
 * 
 * @copyright  (c) 2012 Korney Czukowski
 */
class TachelhitSrc extends IntegerRule
{

    public function pluralCategory($count)
    {
        if ($count >= 0 AND $count <= 1) {
            return 'one';
        } elseif ($this->isInt($count) AND $count >= 2 AND $count <= 10) {
            return 'few';
        } else {
            return 'other';
        }
    }

}
