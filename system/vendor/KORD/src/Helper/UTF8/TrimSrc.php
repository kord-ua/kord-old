<?php

namespace KORD\Helper\UTF8;

use KORD\Helper\UTF8;

/**
 * @copyright  (c) 2007–2014 Kohana Team
 * @copyright  (c) 2005 Harry Fuecks
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 */
class TrimSrc
{

    public static function trim($str, $charlist = null)
    {
        if ($charlist === null) {
            return trim($str);
        }

        return Trim::ltrim(Trim::rtrim($str, $charlist), $charlist);
    }

    public static function ltrim($str, $charlist = null)
    {
        if ($charlist === null) {
            return ltrim($str);
        }

        if (UTF8::isAscii($charlist)) {
            return ltrim($str, $charlist);
        }

        $charlist = preg_replace('#[-\[\]:\\\\^/]#', '\\\\$0', $charlist);

        return preg_replace('/^[' . $charlist . ']+/u', '', $str);
    }

    public static function rtrim($str, $charlist = null)
    {
        if ($charlist === null) {
            return rtrim($str);
        }

        if (UTF8::isAscii($charlist)) {
            return rtrim($str, $charlist);
        }

        $charlist = preg_replace('#[-\[\]:\\\\^/]#', '\\\\$0', $charlist);

        return preg_replace('/[' . $charlist . ']++$/uD', '', $str);
    }

}
