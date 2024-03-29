<?php

namespace KORD\Helper\UTF8;

use KORD\Helper\UTF8;

/**
 * @copyright  (c) 2007–2014 Kohana Team
 * @copyright  (c) 2005 Harry Fuecks
 * @copyright  (c) 2014 Andriy Strepetov
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 */
class StringLengthSrc
{

    public static function strlen($str)
    {
        if (UTF8::isAscii($str)) {
            return strlen($str);
        }

        return strlen(utf8_decode($str));
    }

    public static function strspn($str, $mask, $offset = null, $length = null)
    {
        if ($str == '' OR $mask == '') {
            return 0;
        }

        if (UTF8::isAscii($str) AND UTF8::isAscii($mask)) {
            return ($offset === null) ? strspn($str, $mask) : (($length === null) ? strspn($str, $mask, $offset) : strspn($str, $mask, $offset, $length));
        }

        if ($offset !== null OR $length !== null) {
            $str = UTF8::substr($str, $offset, $length);
        }

        // Escape these characters:  - [ ] . : \ ^ /
        // The . and : are escaped to prevent possible warnings about POSIX regex elements
        $mask = preg_replace('#[-[\].:\\\\^/]#', '\\\\$0', $mask);
        preg_match('/^[^' . $mask . ']+/u', $str, $matches);

        return isset($matches[0]) ? UTF8::strlen($matches[0]) : 0;
    }

    public static function strcspn($str, $mask, $offset = null, $length = null)
    {
        if ($str == '' OR $mask == '') {
            return 0;
        }

        if (UTF8::isAscii($str) AND UTF8::isAscii($mask)) {
            return ($offset === null) ? strcspn($str, $mask) : (($length === null) ? strcspn($str, $mask, $offset) : strcspn($str, $mask, $offset, $length));
        }


        if ($offset !== null OR $length !== null) {
            $str = UTF8::substr($str, $offset, $length);
        }

        // Escape these characters:  - [ ] . : \ ^ /
        // The . and : are escaped to prevent possible warnings about POSIX regex elements
        $mask = preg_replace('#[-[\].:\\\\^/]#', '\\\\$0', $mask);
        preg_match('/^[^' . $mask . ']+/u', $str, $matches);

        return isset($matches[0]) ? UTF8::strlen($matches[0]) : 0;
    }

}
