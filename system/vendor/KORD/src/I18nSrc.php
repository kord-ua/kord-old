<?php

/**
 * Internationalization (i18n) class. Provides language loading and translation
 * methods without dependencies on [gettext](http://php.net/gettext).
 *
 * Typically this class would never be used directly, but used via the __()
 * function, which loads the message and replaces parameters:
 *
 *     // Display a translated message
 *     echo __('hello.world');
 *
 *     // With parameter replacement
 *     ___('{count} user is online', 1000, ['count' => 1000]);
 *
 */

namespace KORD {

    class I18nSrc
    {

        /**
         * @var  string   target language: en-us, es-es, zh-cn, etc
         */
        protected $lang = 'en-us';

        /**
         * @var  array  \KORD\I18n\Reader\ReaderInterface instances
         */
        protected $readers = [];

        /**
         * @var  array  Plural rules classes instances
         */
        protected $rules = [];

        /**
         * @var  \KORD\I18n\Plural\Factory
         */
        protected $plural_rules_factory;

        /**
         * Attach an i18n reader
         * 
         * @param  \KORD\I18n\Reader\ReaderInterface  $reader
         */
        public function attach(\KORD\I18n\Reader\ReaderInterface $reader)
        {
            $this->readers[] = $reader;
        }

        /**
         * Get and set the target language.
         *
         *     // Get the current language
         *     $lang = $i18n->lang();
         *
         *     // Change the current language to Spanish
         *     $i18n->lang('es-es');
         *
         * @param   string  $lang   new language setting
         * @return  string
         */
        public function lang($lang = null)
        {
            if ($lang) {
                // Normalize the language
                $this->lang = strtolower(str_replace(array(' ', '_'), '-', $lang));
            }

            return $this->lang;
        }

        /**
         * Translation/internationalization function with context support.
         * The PHP function [strtr](http://php.net/strtr) is used for replacing parameters.
         * 
         *    $i18n->translate(':count user is online', 1000, [':count' => 1000]);
         *    // 1000 users are online
         * 
         * @param   string  $string   String to translate
         * @param   mixed   $context  String form or numeric count
         * @param   array   $values   Param values to insert
         * @param   string  $lang     Target language
         * @return  string
         */
        public function translate($string, $context, $values, $lang = null)
        {
            if (is_numeric($context)) {
                // Get plural form
                $string = $this->plural($string, $context, $lang);
            } else {
                // Get custom form
                $string = $this->form($string, $context, $lang);
            }

            // PSR-3 compatibility
            if (!empty($values) AND is_array($values)) {
                foreach ($values as $key => $val) {
                    if (preg_match('/^[A-Za-z0-9]+$/', $key)) {
                        $values['{' . $key . '}'] = $val;
                        unset($values[$key]);
                    }
                }
            }

            return empty($values) ? $string : strtr($string, $values);
        }

        /**
         * Returns specified form of a string translation. If no translation exists, the original string will be
         * returned. No parameters are replaced.
         * 
         *     $hello = $i18n->form('I\'ve met :name, he is my friend now.', 'fem');
         *     // I've met :name, she is my friend now.
         * 
         * @param   string  $string
         * @param   string  $form, if null, looking for 'other' form, else the very first form
         * @param   string  $lang
         * @return  string
         */
        public function form($string, $form = null, $lang = null)
        {
            $translation = $this->get($string, $lang);
            if (is_array($translation)) {
                if (array_key_exists($form, $translation)) {
                    return $translation[$form];
                } elseif (array_key_exists('other', $translation)) {
                    return $translation['other'];
                }
                return reset($translation);
            }
            return $translation;
        }

        /**
         * Returns translation of a string. If no translation exists, the original string will be
         * returned. No parameters are replaced.
         * 
         *     $hello = $i18n->plural('Hello, my name is :name and I have :count friend.', 10);
         *     // Hello, my name is :name and I have :count friends.
         * 
         * @param   string  $string
         * @param   mixed   $count
         * @param   string  $lang
         * @return  string
         */
        public function plural($string, $count = 0, $lang = null)
        {
            // Get the translation form key
            $form = $this->pluralRules($lang)
                    ->pluralCategory($count);
            // Return the translation for that form
            return $this->form($string, $form, $lang);
        }

        /**
         * Returns the translation from the first reader where it exists, or the input string
         * if no translation is available.
         * 
         * @param   string  $string
         * @param   string  $lang
         * @return  string
         */
        protected function get($string, $lang)
        {
            foreach ($this->readers as $reader) {
                if (($translation = $reader->get($string, $lang))) {
                    return $translation;
                }
            }
            return $string;
        }

        /**
         * Plural rules lazy initialization
         * 
         * @param   string  $lang
         * @return  \KORD\I18n\Plural\Rules
         */
        protected function pluralRules($lang)
        {
            if (!isset($this->rules[$lang])) {
                // Get language code prefix
                $parts = explode('-', $lang, 2);
                $this->rules[$lang] = $this->pluralRulesFactory()
                        ->createRules($parts[0]);
            }
            return $this->rules[$lang];
        }

        /**
         * @return  \KORD\I18n\Plural\Factory
         */
        protected function pluralRulesFactory()
        {
            if ($this->plural_rules_factory === null) {
                $this->plural_rules_factory = new \KORD\I18n\Plural\Factory;
            }
            return $this->plural_rules_factory;
        }

    }

}

namespace {

    use KORD\Core;

if (!function_exists('__')) {

        /**
         * This is a gateway to the `\KORD\I18n\Core` functions, as there's 
         * no static access to it.
         * 
         *    ___('{count} user is online', 1000, ['count' => 1000]);
         *    // 1000 users are online
         * 
         * @uses    \KORD\I18n::translate()
         * @param   string  $string to translate
         * @param   mixed   $context string form or numeric count
         * @param   array   $values param values to insert
         * @param   string  $lang target language
         * @return  string
         */
        function __($string, $context = 0, $values = null, $lang = null)
        {
            if (is_array($context) AND ! is_array($values)) {
                // Assume no form is specified and the 2nd argument are parameters
                $lang = $values;
                $values = $context;
                $context = 0;
            }
            if ($lang === null) {
                $lang = Core::$i18n->lang();
            }
            return Core::$i18n->translate($string, $context, $values, $lang);
        }

    }
}
