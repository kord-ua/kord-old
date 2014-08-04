<?php

/**
 * Plural rules for Colognian language:
 * 
 * Locales: ksh
 * 
 * Languages:
 * - Colognian (ksh)
 * 
 * Rules:
 *  zero → n is 0;
 *  one → n is 1;
 *  other → everything else
 * 
 * Reference CLDR Version 21 (2012-03-01 03:27:30 GMT)
 * @see  http://unicode.org/repos/cldr-tmp/trunk/diff/supplemental/language_plural_rules.html
 * @see  http://unicode.org/repos/cldr/trunk/common/supplemental/plurals.xml
 * 
 * @copyright  (c) 2012 Korney Czukowski
 */

namespace KORD\I18n\Plural;

class ColognianSrc implements PluralInterface
{

    public function pluralCategory($count)
    {
        if ($count == 0) {
            return 'zero';
        }
        if ($count == 1) {
            return 'one';
        } else {
            return 'other';
        }
    }

}
