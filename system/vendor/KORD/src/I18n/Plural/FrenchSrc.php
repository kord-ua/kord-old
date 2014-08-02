<?php

/**
 * Plural rules for the following locales and languages:
 * 
 * Locales: ff fr kab
 * 
 * Languages:
 *  Fulah (ff)
 *  French (fr)
 *  Kabyle (kab)
 * 
 * Rules:
 *  one → n within 0..2 and n is not 2;
 *  other → everything else
 * 
 * Reference CLDR Version 21 (2012-03-01 03:27:30 GMT)
 * @see  http://unicode.org/repos/cldr-tmp/trunk/diff/supplemental/language_plural_rules.html
 * @see  http://unicode.org/repos/cldr/trunk/common/supplemental/plurals.xml
 */

namespace KORD\I18n\Plural;

class FrenchSrc implements PluralInterface
{

    public function pluralCategory($count)
    {
        if ($count >= 0 AND $count < 2) {
            return 'one';
        } else {
            return 'other';
        }
    }

}
