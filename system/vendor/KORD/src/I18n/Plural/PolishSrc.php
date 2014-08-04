<?php

/**
 * Plural rules for Polish language:
 * 
 * Locales: pl
 * 
 * Languages:
 * - Polish (pl)
 * 
 * Rules:
 * 	one → n is 1;
 * 	few → n mod 10 in 2..4 and n mod 100 not in 12..14 and n mod 100 not in 22..24;
 * 	other → everything else (fractions)
 * 
 * Reference CLDR Version 21 (2012-03-01 03:27:30 GMT)
 * @see  http://unicode.org/repos/cldr-tmp/trunk/diff/supplemental/language_plural_rules.html
 * @see  http://unicode.org/repos/cldr/trunk/common/supplemental/plurals.xml
 * 
 * @copyright  (c) 2012 Korney Czukowski
 */

namespace KORD\I18n\Plural;

class PolishSrc extends IntegerRule
{

    public function pluralCategory($count)
    {
        if ($count == 1) {
            return 'one';
        } elseif ($this->isInt($count) AND ( $i = $count % 10) >= 2 AND $i <= 4 AND ! (($i = $count % 100) >= 12 AND $i <= 14) AND ! ($i >= 22 AND $i <= 24)) {
            return 'few';
        } else {
            return 'other';
        }
    }

}
