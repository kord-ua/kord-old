<?php

namespace KORD\I18n\Plural;

/**
 * Plural rules for Central Morocco Tamazight language:
 * 
 * Locales: tzm
 * 
 * Languages:
 *  Central Morocco Tamazight (tzm)
 * 
 * Rules:
 *  one → n in 0..1 or n in 11..99;
 *  other → everything else
 * 
 * Reference CLDR Version 21 (2012-03-01 03:27:30 GMT)
 * @see  http://unicode.org/repos/cldr-tmp/trunk/diff/supplemental/language_plural_rules.html
 * @see  http://unicode.org/repos/cldr/trunk/common/supplemental/plurals.xml
 * 
 * @copyright  (c) 2012 Korney Czukowski
 */
class TamazightSrc extends IntegerRule
{

    public function pluralCategory($count)
    {
        if ($this->isInt($count) AND ( $count == 0 OR $count == 1 OR ( $count >= 11 AND $count <= 99))) {
            return 'one';
        } else {
            return 'other';
        }
    }

}
