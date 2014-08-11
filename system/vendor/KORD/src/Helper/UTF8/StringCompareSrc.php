<?php

namespace KORD\Helper\UTF8;

use KORD\Helper\UTF8;

/**
 * @copyright  (c) 2007–2014 Kohana Team
 * @copyright  (c) 2005 Harry Fuecks
 * @copyright  (c) 2014 Andriy Strepetov
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 */
class StringCompareSrc
{

    public static function strcasecmp($str1, $str2)
    {
        if (UTF8::isAscii($str1) AND UTF8::isAscii($str2)) {
            return strcasecmp($str1, $str2);
        }

        $str1 = UTF8::strtolower($str1);
        $str2 = UTF8::strtolower($str2);
        return strcmp($str1, $str2);
    }

}
