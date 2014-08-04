<?php

/**
 * Plural rules for Langi language:
 * 
 * Locales: lag
 * 
 * Languages:
 * - Langi (lag)
 * 
 * Rules:
 * 	zero → n is 0;
 * 	one → n within 0..2 and n is not 0 and n is not 2;
 * 	other → everything else
 * 
 * Reference CLDR Version 21 (2012-03-01 03:27:30 GMT)
 * @see  http://unicode.org/repos/cldr-tmp/trunk/diff/supplemental/language_plural_rules.html
 * @see  http://unicode.org/repos/cldr/trunk/common/supplemental/plurals.xml
 * 
 * @copyright  (c) 2012 Korney Czukowski
 */

namespace KORD\I18n\Plural;

class LangiSrc implements PluralInterface
{

    public function pluralCategory($count)
    {
        if ($count == 0) {
            return 'zero';
        } elseif ($count > 0 AND $count < 2) {
            return 'one';
        } else {
            return 'other';
        }
    }

}
