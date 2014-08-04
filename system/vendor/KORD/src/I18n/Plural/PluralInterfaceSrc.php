<?php

/**
 * Interface for \KORD\I18n\Plural Rules
 * 
 * @copyright  (c) 2012 Korney Czukowski
 */

namespace KORD\I18n\Plural;

interface PluralInterfaceSrc
{

    /**
     * Returns category key by count
     * 
     * @param   integer  $count
     * @return  string
     */
    public function pluralCategory($count);
}
