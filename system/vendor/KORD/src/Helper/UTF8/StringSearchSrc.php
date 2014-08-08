<?php

namespace KORD\Helper\UTF8;

use KORD\Helper\UTF8;

/**
 * @copyright  (c) 2007–2014 Kohana Team
 * @copyright  (c) 2005 Harry Fuecks
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 */
class StringSearchSrc
{

    public static function strpos($str, $search, $offset = 0)
    {
        $offset = (int) $offset;

        if (UTF8::isAscii($str) AND UTF8::isAscii($search)) {
            return strpos($str, $search, $offset);
        }

        if ($offset == 0) {
            $array = explode($search, $str, 2);
            return isset($array[1]) ? UTF8::strlen($array[0]) : false;
        }

        $str = UTF8::substr($str, $offset);
        $pos = UTF8::strpos($str, $search);
        return ($pos === false) ? false : ($pos + $offset);
    }

    public static function strrpos($str, $search, $offset = 0)
    {
        $offset = (int) $offset;

        if (UTF8::isAscii($str) AND UTF8::isAscii($search)) {
            return strrpos($str, $search, $offset);
        }

        if ($offset == 0) {
            $array = explode($search, $str, -1);
            return isset($array[0]) ? UTF8::strlen(implode($search, $array)) : false;
        }

        $str = UTF8::substr($str, $offset);
        $pos = UTF8::strrpos($str, $search);
        return ($pos === false) ? false : ($pos + $offset);
    }

    public static function stristr($str, $search)
    {
        if (UTF8::isAscii($str) AND UTF8::isAscii($search)) {
            return stristr($str, $search);
        }

        if ($search == '') {
            return $str;
        }

        $str_lower = UTF8::strtolower($str);
        $search_lower = UTF8::strtolower($search);

        preg_match('/^(.*?)' . preg_quote($search_lower, '/') . '/s', $str_lower, $matches);

        if (isset($matches[1])) {
            return substr($str, strlen($matches[1]));
        }

        return false;
    }

}
