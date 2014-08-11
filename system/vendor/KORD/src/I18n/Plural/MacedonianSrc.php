<?php

namespace KORD\I18n\Plural;

/**
 * Plural rules for Macedonian language:
 * 
 * Locales: mk
 * 
 * Languages:
 * - Macedonian (mk)
 * 
 * Rules:
 * 	one → n mod 10 is 1 and n is not 11;
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
class MacedonianSrc extends IntegerRule
{

    public function pluralCategory($count)
    {
        if ($this->isInt($count) AND $count % 10 == 1 AND $count != 11) {
            return 'one';
        } else {
            return 'other';
        }
    }

}
