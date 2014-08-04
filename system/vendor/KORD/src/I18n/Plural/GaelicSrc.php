<?php

/**
 * Plural rules for Scottish Gaelic language:
 * 
 * Locales: gd
 * 
 * Languages:
 * - Scottish Gaelic (gd)
 * 
 * Rules:
 *  one → n in 1,11;
 *  two → n in 2,12;
 *  few → n in 3..10,13..19;
 *  other → everything else
 * 
 * Reference CLDR Version 21 (2012-03-01 03:27:30 GMT)
 * @see  http://unicode.org/repos/cldr-tmp/trunk/diff/supplemental/language_plural_rules.html
 * @see  http://unicode.org/repos/cldr/trunk/common/supplemental/plurals.xml
 * 
 * @copyright  (c) 2012 Korney Czukowski
 */

namespace KORD\I18n\Plural;

class GaelicSrc extends IntegerRule
{

    public function pluralCategory($count)
    {
        if ($count == 1 OR $count == 11) {
            return 'one';
        } elseif ($count == 2 OR $count == 12) {
            return 'two';
        } elseif ($this->isInt($count) AND ( ($count >= 3 AND $count <= 10) OR ( $count >= 13 AND $count <= 19))) {
            return 'few';
        } else {
            return 'other';
        }
    }

}
