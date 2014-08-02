<?php

/**
 * I18n Reader Interface
 * 
 * The Reader must be able to return an associative array, if more than one translation option is available.
 * The 'other' key has a special meaning of a default translation.
 * 
 */

namespace KORD\I18n\Reader;

interface ReaderInterfaceSrc
{

    /**
     * Returns the translation(s) of a string or null if there's no translation for the string.
     * No parameters are replaced.
     * 
     * @param   string   text to translate
     * @param   string   target language
     * @return  mixed
     */
    public function get($string, $lang = null);
}
