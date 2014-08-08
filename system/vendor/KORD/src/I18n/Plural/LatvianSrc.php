<?php

namespace KORD\I18n\Plural;

/**
 * Plural rules for Latvian language:
 * 
 * Locales: lv
 * 
 * Languages:
 * - Latvian (lv)
 * 
 * Rules:
 * 	zero → n is 0;
 * 	one → n mod 10 is 1 and n mod 100 is not 11;
 * 	other → everything else
 * 
 * Reference CLDR Version 21 (2012-03-01 03:27:30 GMT)
 * @see  http://unicode.org/repos/cldr-tmp/trunk/diff/supplemental/language_plural_rules.html
 * @see  http://unicode.org/repos/cldr/trunk/common/supplemental/plurals.xml
 * 
 * @copyright  (c) 2012 Korney Czukowski
 */
class LatvianSrc extends IntegerRule
{

    public function pluralCategory($count)
    {
        if ($count == 0) {
            return 'zero';
        } elseif ($this->isInt($count) AND $count % 10 == 1 AND $count % 100 != 11) {
            return 'one';
        } else {
            return 'other';
        }
    }

}
