<?php

/**
 * Plural rules for Maltese language:
 * 
 * Locales: mt
 * 
 * Languages:
 * - Maltese (mt)
 * 
 * Rules:
 * 	one → n is 1;
 * 	few → n is 0 or n mod 100 in 2..10;
 * 	many → n mod 100 in 11..19;
 * 	other → everything else
 * 
 * Reference CLDR Version 21 (2012-03-01 03:27:30 GMT)
 * @see  http://unicode.org/repos/cldr-tmp/trunk/diff/supplemental/language_plural_rules.html
 * @see  http://unicode.org/repos/cldr/trunk/common/supplemental/plurals.xml
 * 
 * @copyright  (c) 2012 Korney Czukowski
 */

namespace KORD\I18n\Plural;

class MalteseSrc extends IntegerRule
{

    public function pluralCategory($count)
    {
        $is_int = $this->isInt($count);
        if ($count == 1) {
            return 'one';
        } elseif ($count == 0 OR $is_int AND ( $i = $count % 100) >= 2 AND $i <= 10) {
            return 'few';
        } elseif ($is_int AND ( $i = $count % 100) >= 11 AND $i <= 19) {
            return 'many';
        } else {
            return 'other';
        }
    }

}
