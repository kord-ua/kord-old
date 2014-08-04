<?php

/**
 * \KORD\UTF8::strcasecmp
 *
 * @copyright  (c) 2007–2014 Kohana Team
 * @copyright  (c) 2005 Harry Fuecks
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 */
function _strcasecmp($str1, $str2)
{
    if (\KORD\UTF8::isAscii($str1) AND \KORD\UTF8::isAscii($str2)) {
        return strcasecmp($str1, $str2);
    }
    
    $str1 = \KORD\UTF8::strtolower($str1);
    $str2 = \KORD\UTF8::strtolower($str2);
    return strcmp($str1, $str2);
}
