<?php

namespace KORD\Helper;

/**
 * Inflector helper class. Inflection is changing the form of a word based on
 * the context it is used in. For example, changing a word into a plural form.
 *
 * [!!] Inflection is only tested with English and will not work with other languages.
 * 
 * @copyright  (c) 2007–2014 Kohana Team
 * @copyright  (c) 2014 Andriy Strepetov
 */
abstract class InflectorSrc
{

    /**
     * @var  array  cached inflections
     */
    protected static $cache = [];

    /**
     * @var  array  uncountable words
     */
    public static $uncountable = [
        'access',
        'advice',
        'aircraft',
        'art',
        'baggage',
        'bison',
        'dances',
        'deer',
        'equipment',
        'fish',
        'fuel',
        'furniture',
        'heat',
        'honey',
        'homework',
        'impatience',
        'information',
        'knowledge',
        'luggage',
        'media',
        'money',
        'moose',
        'music',
        'news',
        'patience',
        'progress',
        'pollution',
        'research',
        'rice',
        'salmon',
        'sand',
        'series',
        'sheep',
        'sms',
        'spam',
        'species',
        'staff',
        'swine',
        'toothpaste',
        'traffic',
        'understanding',
        'water',
        'weather',
        'work',
    ];

    /**
     * @var  array  irregular words
     */
    public static $irregular = [
        'appendix' => 'appendices',
        'cactus' => 'cacti',
        'calf' => 'calves',
        'child' => 'children',
        'crisis' => 'crises',
        'criterion' => 'criteria',
        'curriculum' => 'curricula',
        'diagnosis' => 'diagnoses',
        'elf' => 'elves',
        'ellipsis' => 'ellipses',
        'foot' => 'feet',
        'goose' => 'geese',
        'hero' => 'heroes',
        'hoof' => 'hooves',
        'hypothesis' => 'hypotheses',
        'is' => 'are',
        'knife' => 'knives',
        'leaf' => 'leaves',
        'life' => 'lives',
        'loaf' => 'loaves',
        'man' => 'men',
        'mouse' => 'mice',
        'nucleus' => 'nuclei',
        'oasis' => 'oases',
        'octopus' => 'octopi',
        'ox' => 'oxen',
        'paralysis' => 'paralyses',
        'parenthesis' => 'parentheses',
        'person' => 'people',
        'phenomenon' => 'phenomena',
        'potato' => 'potatoes',
        'quiz' => 'quizzes',
        'radius' => 'radii',
        'scarf' => 'scarves',
        'stimulus' => 'stimuli',
        'syllabus' => 'syllabi',
        'synthesis' => 'syntheses',
        'thief' => 'thieves',
        'tooth' => 'teeth',
        'was' => 'were',
        'wharf' => 'wharves',
        'wife' => 'wives',
        'woman' => 'women',
        'release' => 'releases',
    ];

    /**
     * Checks if a word is defined as uncountable. An uncountable word has a
     * single form. For instance, one "fish" and many "fish", not "fishes".
     *
     *     \KORD\Inflector::uncountable('fish'); // true
     *     \KORD\Inflector::uncountable('cat');  // false
     *
     * If you find a word is being pluralized improperly, it has probably not
     * been defined as uncountable.
     *
     * @param   string  $str    word to check
     * @return  boolean
     */
    public static function uncountable($str)
    {
        return in_array(strtolower($str), Inflector::$uncountable);
    }

    /**
     * Makes a plural word singular.
     *
     *     echo \KORD\Inflector::singular('cats'); // "cat"
     *     echo \KORD\Inflector::singular('fish'); // "fish", uncountable
     *
     * [!!] Special inflections are defined in `config/inflector.php`.
     *
     * @param   string  $str    word to make singular
     * @return  string
     * @uses    \KORD\Inflector::uncountable
     */
    public static function singular($str)
    {
        // Remove garbage
        $str = strtolower(trim($str));

        // Cache key name
        $key = 'singular_' . $str;

        if (isset(Inflector::$cache[$key])) {
            return Inflector::$cache[$key];
        }
        
        $str_part1 = '';
        
        if (($pos = strrpos(trim($str, "-"), "-")) !== false) {
            $str_part1 = substr($str, 0, $pos+1);
            $str = substr($str, $pos+1);
        }
        
        if (($pos = strrpos(trim($str, "_"), "_")) !== false) {
            $str_part1 .= substr($str, 0, $pos+1);
            $str = substr($str, $pos+1);
        }

        if (Inflector::uncountable($str)) {
            return Inflector::$cache[$key] = $str_part1 . $str;
        }

        if ($irregular = array_search($str, Inflector::$irregular)) {
            $str = $irregular;
        } elseif (preg_match('/us$/', $str)) {
            // http://en.wikipedia.org/wiki/Plural_form_of_words_ending_in_-us
            // Already singular, do nothing
        } elseif (preg_match('/[sxz]es$/', $str) OR preg_match('/[^aeioudgkprt]hes$/', $str)) {
            // Remove "es"
            $str = substr($str, 0, -2);
        } elseif (preg_match('/[^aeiou]ies$/', $str)) {
            // Replace "ies" with "y"
            $str = substr($str, 0, -3) . 'y';
        } elseif (substr($str, -1) === 's' AND substr($str, -2) !== 'ss') {
            // Remove singular "s"
            $str = substr($str, 0, -1);
        }

        return Inflector::$cache[$key] = $str_part1 . $str;
    }

    /**
     * Makes a singular word plural.
     *
     *     echo \KORD\Inflector::plural('fish'); // "fish", uncountable
     *     echo \KORD\Inflector::plural('cat');  // "cats"
     *
     * [!!] Special inflections are defined in `config/inflector.php`.
     *
     * @param   string  $str    word to pluralize
     * @return  string
     * @uses    \KORD\Inflector::uncountable
     */
    public static function plural($str)
    {
        // Remove garbage
        $str = trim($str);

        // Cache key name
        $key = 'plural_' . $str;

        // Check uppercase
        $is_uppercase = ctype_upper($str);

        if (isset(Inflector::$cache[$key])) {
            return Inflector::$cache[$key];
        }
        
        $str_part1 = '';
        
        if (($pos = strrpos(trim($str, "-"), "-")) !== false) {
            $str_part1 = substr($str, 0, $pos+1);
            $str = substr($str, $pos+1);
        }
        
        if (($pos = strrpos(trim($str, "_"), "_")) !== false) {
            $str_part1 .= substr($str, 0, $pos+1);
            $str = substr($str, $pos+1);
        }

        if (Inflector::uncountable($str)) {
            return Inflector::$cache[$key] = $str_part1 . $str;
        }

        if (isset(Inflector::$irregular[$str])) {
            $str = Inflector::$irregular[$str];
        } elseif (in_array($str, Inflector::$irregular)) {
            // Do nothing
        } elseif (preg_match('/[sxz]$/', $str) OR preg_match('/[^aeioudgkprt]h$/', $str)) {
            $str .= 'es';
        } elseif (preg_match('/[^aeiou]y$/', $str)) {
            // Change "y" to "ies"
            $str = substr_replace($str, 'ies', -1);
        } else {
            $str .= 's';
        }

        // Convert to uppercase if necessary
        if ($is_uppercase) {
            $str = strtoupper($str);
        }

        // Set the cache and return
        return Inflector::$cache[$key] = $str_part1 . $str;
    }

}
