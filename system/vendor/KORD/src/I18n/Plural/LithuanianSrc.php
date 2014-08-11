<?php

namespace KORD\I18n\Plural;

/**
 * Plural rules for Lithuanian language:
 * 
 * Locales: lt
 * 
 * Languages:
 * - Lithuanian (lt)
 * 
 * Rules:
 * 	one → n mod 10 is 1 and n mod 100 not in 11..19;
 * 	few → n mod 10 in 2..9 and n mod 100 not in 11..19;
 * 	other → everything else
 * 
 * Reference CLDR Version 21 (2012-03-01 03:27:30 GMT)
 * @see  http://unicode.org/repos/cldr-tmp/trunk/diff/supplemental/language_plural_rules.html
 * @see  http://unicode.org/repos/cldr/trunk/common/supplemental/plurals.xml
 * 
 * @copyright  (c) 2012 Korney Czukowski
 * @copyright  (c) 2014 Andriy Strepetov
 * @license    MIT License
 */
class LithuanianSrc extends IntegerRule
{

    public function pluralCategory($count)
    {
        $is_int = $this->isInt($count);
        if ($is_int AND $count % 10 == 1 AND ! (($i = $count % 100) >= 11 AND $i <= 19)) {
            return 'one';
        } elseif ($is_int AND ( $i = $count % 10) >= 2 AND $i <= 9 AND ! (($i = $count % 100) >= 11 AND $i <= 19)) {
            return 'few';
        } else {
            return 'other';
        }
    }

}
