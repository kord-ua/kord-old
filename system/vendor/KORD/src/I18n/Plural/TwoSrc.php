<?php

namespace KORD\I18n\Plural;

/**
 * Plural rules for the following locales and languages:
 * 
 * Locales: iu kw naq se sma smi smj smn sms
 * 
 * Languages:
 *  Inuktitut (iu)
 *  Cornish (kw)
 *  Nama (naq)
 *  Northern Sami (se)
 *  Southern Sami (sma)
 *  Sami Language (smi)
 *  Lule Sami (smj)
 *  Inari Sami (smn)
 *  Skolt Sami (sms)
 * 
 * Rules:
 *  one → n is 1;
 *  two → n is 2;
 *  other → everything else
 * 
 * Reference CLDR Version 21 (2012-03-01 03:27:30 GMT)
 * @see  http://unicode.org/repos/cldr-tmp/trunk/diff/supplemental/language_plural_rules.html
 * @see  http://unicode.org/repos/cldr/trunk/common/supplemental/plurals.xml
 * 
 * @copyright  (c) 2012 Korney Czukowski
 */
class TwoSrc implements PluralInterface
{

    public function pluralCategory($count)
    {
        if ($count == 1) {
            return 'one';
        } elseif ($count == 2) {
            return 'two';
        } else {
            return 'other';
        }
    }

}
