<?php

/**
 * A port of [phputf8](http://phputf8.sourceforge.net/) to a unified set
 * of files. Provides multi-byte aware replacement string functions.
 *
 * For UTF-8 support to work correctly, the following requirements must be met:
 *
 * - PCRE needs to be compiled with UTF-8 support (--enable-utf8)
 * - Support for [Unicode properties](http://php.net/manual/reference.pcre.pattern.modifiers.php)
 *   is highly recommended (--enable-unicode-properties)
 * - The [mbstring extension](http://php.net/mbstring) is highly recommended,
 *   but must not be overloading string functions
 *
 * [!!] This file is licensed differently from the rest of KORD. As a port of
 * [phputf8](http://phputf8.sourceforge.net/), this file is released under the LGPL.
 *
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 * @copyright  (c) 2005 Harry Fuecks
 * @copyright  (c) 2007–2014 Kohana Team
 */

namespace KORD;

use KORD\Core;
use KORD\UTF8;

class UTF8Src
{

    /**
     * @var  boolean  Does the server support UTF-8 natively?
     */
    protected static $unicode_enabled = null;
    
    /**
     * @var  boolean  Is mbstring extension available
     */
    protected static $mbstring_enabled = null;

    /**
     * @var  array  List of called methods that have had their required file included.
     */
    public static $called = [];
    
    /**
     * Checks if PCRE is compiled with UTF-8 and Unicode support
     *
     * @return boolean
     */
    public static function unicodeEnabled()
    {
        if (UTF8::$unicode_enabled === null) {
            // Determine if this server supports UTF-8 natively
            UTF8::$unicode_enabled = (@preg_match('/\pL/u', 'a')) ? true : false;
        }

        return UTF8::$unicode_enabled;
    }
    

    /**
     * Checks if PHP mbstring extension is enabled (loaded)
     * 
     * @return boolean
     */
    public static function mbstringEnabled()
    {
        if (UTF8::$mbstring_enabled === null) {
            // Determine if this server supports mbstring functions
            UTF8::$mbstring_enabled = extension_loaded('mbstring');
        }

        return UTF8::$mbstring_enabled;
    }
    
    /**
     * Checks if PHP mbstring supports provided encoding
     * 
     * @param string $encoding tested encoding
     * @return boolean
     */
    public static function mbstringEncodingSupported($encoding)
    {
        if (!UTF8::mbstringEnabled()) {
            return false;
        }

        return in_array(strtolower($encoding), array_map('strtolower', mb_list_encodings()));
    }

    /**
     * Recursively cleans arrays, objects, and strings. Removes ASCII control
     * codes and converts to the requested charset while silently discarding
     * incompatible characters.
     *
     *     \KORD\UTF8::clean($_GET); // Clean GET data
     *
     * @param   mixed   $var        variable to clean
     * @param   string  $charset    character set, defaults to \KORD\Core::$charset
     * @return  mixed
     * @uses    \KORD\UTF8::clean
     * @uses    \KORD\UTF8::stripAsciiCtrl
     * @uses    \KORD\UTF8::isAscii
     */
    public static function clean($var, $charset = null)
    {
        if (!$charset) {
            // Use the application character set
            $charset = Core::$charset;
        }

        if (is_array($var) OR is_object($var)) {
            foreach ($var as $key => $val) {
                // Recursion!
                $var[UTF8::clean($key)] = UTF8::clean($val);
            }
        } elseif (is_string($var) AND $var !== '') {
            // Remove control characters
            $var = UTF8::stripAsciiCtrl($var);

            if (!UTF8::isAscii($var)) {
                // Disable notices
                $error_reporting = error_reporting(~E_NOTICE);

                $var = mb_convert_encoding($var, $charset, $charset);

                // Turn notices back on
                error_reporting($error_reporting);
            }
        }

        return $var;
    }

    /**
     * Tests whether a string contains only 7-bit ASCII bytes. This is used to
     * determine when to use native functions or UTF-8 functions.
     *
     *     $ascii = \KORD\UTF8::isAscii($str);
     *
     * @param   mixed   $str    string or array of strings to check
     * @return  boolean
     */
    public static function isAscii($str)
    {
        if (is_array($str)) {
            $str = implode($str);
        }

        return !preg_match('/[^\x00-\x7F]/S', $str);
    }

    /**
     * Strips out device control codes in the ASCII range.
     *
     *     $str = \KORD\UTF8::stripAsciiCtrl($str);
     *
     * @param   string  $str    string to clean
     * @return  string
     */
    public static function stripAsciiCtrl($str)
    {
        return preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S', '', $str);
    }

    /**
     * Strips out all non-7bit ASCII bytes.
     *
     *     $str = \KORD\UTF8::stripNonAscii($str);
     *
     * @param   string  $str    string to clean
     * @return  string
     */
    public static function stripNonAscii($str)
    {
        return preg_replace('/[^\x00-\x7F]+/S', '', $str);
    }

    /**
     * Replaces special/accented UTF-8 characters by ASCII-7 "equivalents".
     *
     *     $ascii = \KORD\UTF8::transliterate_to_ascii($utf8);
     *
     * @author  Andreas Gohr <andi@splitbrain.org>
     * @param   string  $str    string to transliterate
     * @param   integer $case   -1 lowercase only, +1 uppercase only, 0 both cases
     * @return  string
     */
    public static function transliterateToAscii($str, $case = 0)
    {
        UTF8::includeFunctionFile(__FUNCTION__);

        return _transliterate_to_ascii($str, $case);
    }

    /**
     * Returns the length of the given string. This is a UTF8-aware version
     * of [strlen](http://php.net/strlen).
     *
     *     $length = \KORD\UTF8::strlen($str);
     *
     * @param   string  $str    string being measured for length
     * @param   string  $charset of input string
     * @return  integer
     * @uses    \KORD\UTF8::$mbstring_enabled
     * @uses    \KORD\Core::$charset
     */
    public static function strlen($str, $charset = null)
    {
        if ($charset === null) {
            $charset = Core::$charset;
        }
        
        if (UTF8::mbstringEnabled() AND UTF8::mbstringEncodingSupported($charset)) {
            return mb_strlen($str, $charset);
        }

        UTF8::includeFunctionFile(__FUNCTION__);
        
        return _strlen(iconv($charset, "UTF-8", $str));
    }

    /**
     * Finds position of first occurrence of a UTF-8 string. This is a
     * UTF8-aware version of [strpos](http://php.net/strpos).
     *
     *     $position = \KORD\UTF8::strpos($str, $search);
     *
     * @author  Harry Fuecks <hfuecks@gmail.com>
     * @param   string  $str    haystack
     * @param   string  $search needle
     * @param   integer $offset offset from which character in haystack to start searching
     * @return  integer position of needle
     * @return  boolean false if the needle is not found
     * @uses    \KORD\UTF8::$mbstring_enabled
     * @uses    \KORD\Core::$charset
     */
    public static function strpos($str, $search, $offset = 0)
    {
        if (UTF8::mbstringEnabled()) {
            return mb_strpos($str, $search, $offset, Core::$charset);
        }

        UTF8::includeFunctionFile(__FUNCTION__);

        return _strpos($str, $search, $offset);
    }

    /**
     * Finds position of last occurrence of a char in a UTF-8 string. This is
     * a UTF8-aware version of [strrpos](http://php.net/strrpos).
     *
     *     $position = \KORD\UTF8::strrpos($str, $search);
     *
     * @author  Harry Fuecks <hfuecks@gmail.com>
     * @param   string  $str    haystack
     * @param   string  $search needle
     * @param   integer $offset offset from which character in haystack to start searching
     * @return  integer position of needle
     * @return  boolean false if the needle is not found
     * @uses    \KORD\UTF8::$mbstring_enabled
     */
    public static function strrpos($str, $search, $offset = 0)
    {
        if (UTF8::mbstringEnabled()) {
            return mb_strrpos($str, $search, $offset, Core::$charset);
        }

        UTF8::includeFunctionFile(__FUNCTION__);

        return _strrpos($str, $search, $offset);
    }

    /**
     * Returns part of a UTF-8 string. This is a UTF8-aware version
     * of [substr](http://php.net/substr).
     *
     *     $sub = \KORD\UTF8::substr($str, $offset);
     *
     * @author  Chris Smith <chris@jalakai.co.uk>
     * @param   string  $str    input string
     * @param   integer $offset offset
     * @param   integer $length length limit
     * @return  string
     * @uses    \KORD\UTF8::$mbstring_enabled
     * @uses    \KORD\Core::$charset
     */
    public static function substr($str, $offset, $length = null)
    {
        if (UTF8::mbstringEnabled()) {
            return ($length === null) ? mb_substr($str, $offset, mb_strlen($str), Core::$charset) : mb_substr($str, $offset, $length, Core::$charset);
        }
        
        UTF8::includeFunctionFile(__FUNCTION__);

        return _substr($str, $offset, $length);
    }

    /**
     * Replaces text within a portion of a UTF-8 string. This is a UTF8-aware
     * version of [substr_replace](http://php.net/substr_replace).
     *
     *     $str = \KORD\UTF8::substrReplace($str, $replacement, $offset);
     *
     * @author  Harry Fuecks <hfuecks@gmail.com>
     * @param   string  $str            input string
     * @param   string  $replacement    replacement string
     * @param   integer $offset         offset
     * @return  string
     */
    public static function substrReplace($str, $replacement, $offset, $length = null)
    {
        UTF8::includeFunctionFile(__FUNCTION__);

        return _substr_replace($str, $replacement, $offset, $length);
    }

    /**
     * Makes a UTF-8 string lowercase. This is a UTF8-aware version
     * of [strtolower](http://php.net/strtolower).
     *
     *     $str = \KORD\UTF8::strtolower($str);
     *
     * @author  Andreas Gohr <andi@splitbrain.org>
     * @param   string  $str mixed case string
     * @param   string  $charset of input string
     * @return  string
     * @uses    \KORD\UTF8::$mbstring_enabled
     * @uses    \KORD\Core::$charset
     */
    public static function strtolower($str, $charset = null)
    {
        if ($charset === null) {
            $charset = Core::$charset;
        }
        
        if (UTF8::mbstringEnabled() AND UTF8::mbstringEncodingSupported($charset)) {
            return mb_strtolower($str, $charset);
        }

        UTF8::includeFunctionFile(__FUNCTION__);
        
        return iconv("UTF-8", $charset, _strtolower(iconv($charset, "UTF-8", $str)));
    }

    /**
     * Makes a UTF-8 string uppercase. This is a UTF8-aware version
     * of [strtoupper](http://php.net/strtoupper).
     *
     * @author  Andreas Gohr <andi@splitbrain.org>
     * @param   string  $str mixed case string
     * @param   string  $charset of input string
     * @return  string
     * @uses    \KORD\UTF8::$mbstring_enabled
     * @uses    \KORD\Core::$charset
     */
    public static function strtoupper($str, $charset = null)
    {
        if ($charset === null) {
            $charset = Core::$charset;
        }
        
        if (UTF8::mbstringEnabled() AND UTF8::mbstringEncodingSupported($charset)) {
            return mb_strtoupper($str, $charset);
        }

        UTF8::includeFunctionFile(__FUNCTION__);

        return iconv("UTF-8", $charset, _strtoupper(iconv($charset, "UTF-8", $str)));
    }

    /**
     * Makes a UTF-8 string's first character uppercase. This is a UTF8-aware
     * version of [ucfirst](http://php.net/ucfirst).
     *
     *     $str = \KORD\UTF8::ucfirst($str);
     *
     * @author  Harry Fuecks <hfuecks@gmail.com>
     * @param   string  $str mixed case string
     * @return  string
     */
    public static function ucfirst($str)
    {
        UTF8::includeFunctionFile(__FUNCTION__);

        return _ucfirst($str);
    }

    /**
     * Makes the first character of every word in a UTF-8 string uppercase.
     * This is a UTF8-aware version of [ucwords](http://php.net/ucwords).
     *
     *     $str = \KORD\UTF8::ucwords($str);
     *
     * @author  Harry Fuecks <hfuecks@gmail.com>
     * @param   string  $str mixed case string
     * @return  string
     */
    public static function ucwords($str)
    {
        UTF8::includeFunctionFile(__FUNCTION__);

        return _ucwords($str);
    }

    /**
     * Case-insensitive UTF-8 string comparison. This is a UTF8-aware version
     * of [strcasecmp](http://php.net/strcasecmp).
     *
     *     $compare = \KORD\UTF8::strcasecmp($str1, $str2);
     *
     * @author  Harry Fuecks <hfuecks@gmail.com>
     * @param   string  $str1   string to compare
     * @param   string  $str2   string to compare
     * @return  integer less than 0 if str1 is less than str2
     * @return  integer greater than 0 if str1 is greater than str2
     * @return  integer 0 if they are equal
     */
    public static function strcasecmp($str1, $str2)
    {
        UTF8::includeFunctionFile(__FUNCTION__);

        return _strcasecmp($str1, $str2);
    }

    /**
     * Returns a string or an array with all occurrences of search in subject
     * (ignoring case) and replaced with the given replace value. This is a
     * UTF8-aware version of [str_ireplace](http://php.net/str_ireplace).
     *
     * [!!] This function is very slow compared to the native version. Avoid
     * using it when possible.
     *
     * @author  Harry Fuecks <hfuecks@gmail.com
     * @param   string|array    $search     text to replace
     * @param   string|array    $replace    replacement text
     * @param   string|array    $str        subject text
     * @param   integer         $count      number of matched and replaced needles will be returned via this parameter which is passed by reference
     * @return  string  if the input was a string
     * @return  array   if the input was an array
     */
    public static function strIreplace($search, $replace, $str, & $count = null)
    {
        UTF8::includeFunctionFile(__FUNCTION__);

        return _str_ireplace($search, $replace, $str, $count);
    }

    /**
     * Case-insensitive UTF-8 version of strstr. Returns all of input string
     * from the first occurrence of needle to the end. This is a UTF8-aware
     * version of [stristr](http://php.net/stristr).
     *
     *     $found = \KORD\UTF8::stristr($str, $search);
     *
     * @author  Harry Fuecks <hfuecks@gmail.com>
     * @param   string  $str    input string
     * @param   string  $search needle
     * @return  string  matched substring if found
     * @return  false   if the substring was not found
     */
    public static function stristr($str, $search)
    {
        UTF8::includeFunctionFile(__FUNCTION__);

        return _stristr($str, $search);
    }

    /**
     * Finds the length of the initial segment matching mask. This is a
     * UTF8-aware version of [strspn](http://php.net/strspn).
     *
     *     $found = \KORD\UTF8::strspn($str, $mask);
     *
     * @author  Harry Fuecks <hfuecks@gmail.com>
     * @param   string  $str    input string
     * @param   string  $mask   mask for search
     * @param   integer $offset start position of the string to examine
     * @param   integer $length length of the string to examine
     * @return  integer length of the initial segment that contains characters in the mask
     */
    public static function strspn($str, $mask, $offset = null, $length = null)
    {
        UTF8::includeFunctionFile(__FUNCTION__);

        return _strspn($str, $mask, $offset, $length);
    }

    /**
     * Finds the length of the initial segment not matching mask. This is a
     * UTF8-aware version of [strcspn](http://php.net/strcspn).
     *
     *     $found = \KORD\UTF8::strcspn($str, $mask);
     *
     * @author  Harry Fuecks <hfuecks@gmail.com>
     * @param   string  $str    input string
     * @param   string  $mask   mask for search
     * @param   integer $offset start position of the string to examine
     * @param   integer $length length of the string to examine
     * @return  integer length of the initial segment that contains characters not in the mask
     */
    public static function strcspn($str, $mask, $offset = null, $length = null)
    {
        UTF8::includeFunctionFile(__FUNCTION__);

        return _strcspn($str, $mask, $offset, $length);
    }

    /**
     * Pads a UTF-8 string to a certain length with another string. This is a
     * UTF8-aware version of [str_pad](http://php.net/str_pad).
     *
     *     $str = \KORD\UTF8::strPad($str, $length);
     *
     * @author  Harry Fuecks <hfuecks@gmail.com>
     * @param   string  $str                input string
     * @param   integer $final_str_length   desired string length after padding
     * @param   string  $pad_str            string to use as padding
     * @param   string  $pad_type           padding type: STR_PAD_RIGHT, STR_PAD_LEFT, or STR_PAD_BOTH
     * @return  string
     */
    public static function strPad($str, $final_str_length, $pad_str = ' ', $pad_type = STR_PAD_RIGHT)
    {
        UTF8::includeFunctionFile(__FUNCTION__);

        return _str_pad($str, $final_str_length, $pad_str, $pad_type);
    }

    /**
     * Converts a UTF-8 string to an array. This is a UTF8-aware version of
     * [str_split](http://php.net/str_split).
     *
     *     $array = \KORD\UTF8::strSplit($str);
     *
     * @author  Harry Fuecks <hfuecks@gmail.com>
     * @param   string  $str            input string
     * @param   integer $split_length   maximum length of each chunk
     * @return  array
     */
    public static function strSplit($str, $split_length = 1)
    {
        UTF8::includeFunctionFile(__FUNCTION__);

        return _str_split($str, $split_length);
    }

    /**
     * Reverses a UTF-8 string. This is a UTF8-aware version of [strrev](http://php.net/strrev).
     *
     *     $str = \KORD\UTF8::strrev($str);
     *
     * @author  Harry Fuecks <hfuecks@gmail.com>
     * @param   string  $str string to be reversed
     * @return  string
     */
    public static function strrev($str)
    {
        UTF8::includeFunctionFile(__FUNCTION__);

        return _strrev($str);
    }

    /**
     * Strips whitespace (or other UTF-8 characters) from the beginning and
     * end of a string. This is a UTF8-aware version of [trim](http://php.net/trim).
     *
     *     $str = \KORD\UTF8::trim($str);
     *
     * @author  Andreas Gohr <andi@splitbrain.org>
     * @param   string  $str        input string
     * @param   string  $charlist   string of characters to remove
     * @return  string
     */
    public static function trim($str, $charlist = null)
    {
        UTF8::includeFunctionFile(__FUNCTION__);

        return _trim($str, $charlist);
    }

    /**
     * Strips whitespace (or other UTF-8 characters) from the beginning of
     * a string. This is a UTF8-aware version of [ltrim](http://php.net/ltrim).
     *
     *     $str = \KORD\UTF8::ltrim($str);
     *
     * @author  Andreas Gohr <andi@splitbrain.org>
     * @param   string  $str        input string
     * @param   string  $charlist   string of characters to remove
     * @return  string
     */
    public static function ltrim($str, $charlist = null)
    {
        UTF8::includeFunctionFile(__FUNCTION__);

        return _ltrim($str, $charlist);
    }

    /**
     * Strips whitespace (or other UTF-8 characters) from the end of a string.
     * This is a UTF8-aware version of [rtrim](http://php.net/rtrim).
     *
     *     $str = \KORD\UTF8::rtrim($str);
     *
     * @author  Andreas Gohr <andi@splitbrain.org>
     * @param   string  $str        input string
     * @param   string  $charlist   string of characters to remove
     * @return  string
     */
    public static function rtrim($str, $charlist = null)
    {
        UTF8::includeFunctionFile(__FUNCTION__);

        return _rtrim($str, $charlist);
    }

    /**
     * Returns the unicode ordinal for a character. This is a UTF8-aware
     * version of [ord](http://php.net/ord).
     *
     *     $digit = \KORD\UTF8::ord($character);
     *
     * @author  Harry Fuecks <hfuecks@gmail.com>
     * @param   string  $chr    UTF-8 encoded character
     * @return  integer
     */
    public static function ord($chr)
    {
        UTF8::includeFunctionFile(__FUNCTION__);

        return _ord($chr);
    }

    /**
     * Takes an UTF-8 string and returns an array of ints representing the Unicode characters.
     * Astral planes are supported i.e. the ints in the output can be > 0xFFFF.
     * Occurrences of the BOM are ignored. Surrogates are not allowed.
     *
     *     $array = \KORD\UTF8::toUnicode($str);
     *
     * The Original Code is Mozilla Communicator client code.
     * The Initial Developer of the Original Code is Netscape Communications Corporation.
     * Portions created by the Initial Developer are Copyright (C) 1998 the Initial Developer.
     * Ported to PHP by Henri Sivonen <hsivonen@iki.fi>, see <http://hsivonen.iki.fi/php-utf8/>
     * Slight modifications to fit with phputf8 library by Harry Fuecks <hfuecks@gmail.com>
     *
     * @param   string  $str    UTF-8 encoded string
     * @return  array   unicode code points
     * @return  false   if the string is invalid
     */
    public static function toUnicode($str)
    {
        UTF8::includeFunctionFile(__FUNCTION__);

        return _to_unicode($str);
    }

    /**
     * Takes an array of ints representing the Unicode characters and returns a UTF-8 string.
     * Astral planes are supported i.e. the ints in the input can be > 0xFFFF.
     * Occurrences of the BOM are ignored. Surrogates are not allowed.
     *
     *     $str = \KORD\UTF8::fromUnicode($array);
     *
     * The Original Code is Mozilla Communicator client code.
     * The Initial Developer of the Original Code is Netscape Communications Corporation.
     * Portions created by the Initial Developer are Copyright (C) 1998 the Initial Developer.
     * Ported to PHP by Henri Sivonen <hsivonen@iki.fi>, see http://hsivonen.iki.fi/php-utf8/
     * Slight modifications to fit with phputf8 library by Harry Fuecks <hfuecks@gmail.com>.
     *
     * @param   array   $arr    unicode code points representing a string
     * @return  string  utf8 string of characters
     * @return  boolean false if a code point cannot be found
     */
    public static function fromUnicode($arr)
    {
        UTF8::includeFunctionFile(__FUNCTION__);

        return _from_unicode($arr);
    }

    protected static function includeFunctionFile($function)
    {
        if (!isset(UTF8::$called[$function])) {
            require Core::findFile('utf8', $function);

            // Function has been called
            UTF8::$called[$function] = true;
        }
    }

}
