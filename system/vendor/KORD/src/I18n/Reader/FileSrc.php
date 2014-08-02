<?php

namespace KORD\I18n\Reader;

use KORD\Arr;
use KORD\Core;

class FileSrc implements ReaderInterface
{

    private $cache = [];
    private $directory;

    /**
     * @param  string  $directory
     */
    public function __construct($directory = 'i18n')
    {
        $this->directory = $directory;
    }

    /**
     * Returns the translation(s) of a string or null if there's no translation for the string.
     * No parameters are replaced.
     * 
     * @param   string   text to translate
     * @param   string   target language
     * @return  mixed
     */
    public function get($string, $lang = null)
    {
        if (!$lang) {
            // Use the global target language
            $lang = Core::$i18n->lang();
        }

        // Load the translation table for this language
        $table = $this->load($lang);

        // Return the translated string if it exists
        if (isset($table[$string])) {
            return $table[$string];
        } elseif (($translation = Arr::path($table, $string)) !== null) {
            return $translation;
        }
        return null;
    }

    /**
     * Loads the translation table for a given language.
     * 
     *     // Get all defined Spanish messages
     *     $messages = $i18n->load('es-es');
     * 
     * @param   string  language to load
     * @return  array
     */
    private function load($lang)
    {
        if (isset($this->cache[$lang])) {
            return $this->cache[$lang];
        }

        // New translation table
        $table = [];

        // Split the language: language, region, locale, etc
        $parts = explode('-', $lang);

        do {
            // Create a path for this set of parts
            $path = implode(DS, $parts);
            $files = Core::findFile($this->directory, $path, null, true);
            if ($files) {
                $tables = [];
                foreach ($files as $file) {
                    // Merge the language strings into the sub table
                    $tables = array_merge_recursive($tables, Core::load($file));
                }

                // Append the sub table, preventing less specific language
                // files from overloading more specific files
                $table += $tables;
            }

            // Remove the last part
            array_pop($parts);
        } while ($parts);

        // Cache the translation table locally
        return $this->cache[$lang] = $table;
    }

}
