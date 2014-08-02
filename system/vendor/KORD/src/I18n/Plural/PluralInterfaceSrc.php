<?php

/**
 * Interface for \KORD\I18n\Plural Rules
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
