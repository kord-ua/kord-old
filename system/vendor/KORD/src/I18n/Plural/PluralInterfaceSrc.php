<?php

namespace KORD\I18n\Plural;

/**
 * Interface for \KORD\I18n\Plural Rules
 * 
 * @copyright  (c) 2012 Korney Czukowski
 * @copyright  (c) 2014 Andriy Strepetov
 * @license    MIT License
 */
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
