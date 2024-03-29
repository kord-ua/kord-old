<?php

namespace KORD\I18n\Plural;

/**
 * Plural rules for Breton language:
 * 
 * Locales: br
 * 
 * Languages:
 * - Breton (br)
 * 
 * Rules:
 *  one → n mod 10 is 1 and n mod 100 not in 11,71,91;
 *  two → n mod 10 is 2 and n mod 100 not in 12,72,92;
 *  few → n mod 10 in 3..4,9 and n mod 100 not in 10..19,70..79,90..99;
 *  many → n mod 1000000 is 0 and n is not 0;
 *  other → everything else
 * 
 * Reference CLDR Version 21 (2012-03-01 03:27:30 GMT)
 * @see  http://unicode.org/repos/cldr-tmp/trunk/diff/supplemental/language_plural_rules.html
 * @see  http://unicode.org/repos/cldr/trunk/common/supplemental/plurals.xml
 * 
 * @copyright  (c) 2012 Korney Czukowski
 * @copyright  (c) 2014 Andriy Strepetov
 * @license    MIT License
 */
class BretonSrc extends IntegerRule
{

    public function pluralCategory($count)
    {
        $is_int = $this->isInt($count);
        if ($is_int AND $count % 10 === 1 AND ! in_array($count % 100, array(11, 71, 91))) {
            return 'one';
        } elseif ($is_int AND $count % 10 === 2 AND ! in_array($count % 100, array(12, 72, 92))) {
            return 'two';
        } elseif ($is_int AND in_array($count % 10, array(3, 4, 9)) AND ! ((($i = $count % 100) >= 10 AND $i <= 19) OR ( $i >= 70 AND $i <= 79) OR ( $i >= 90 AND $i <= 99))) {
            return 'few';
        } elseif ($count != 0 AND $count % 1000000 == 0) {
            return 'many';
        } else {
            return 'other';
        }
    }

}
