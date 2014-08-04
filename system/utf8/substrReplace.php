<?php

/**
 * \KORD\UTF8::substrReplace
 *
 * @copyright  (c) 2007–2014 Kohana Team
 * @copyright  (c) 2005 Harry Fuecks
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 */
function _substr_replace($str, $replacement, $offset, $length = null)
{
    if (\KORD\UTF8::isAscii($str)) {
        return ($length === null) ? substr_replace($str, $replacement, $offset) : substr_replace($str, $replacement, $offset, $length);
    }

    $length = ($length === null) ? \KORD\UTF8::strlen($str) : (int) $length;
    preg_match_all('/./us', $str, $str_array);
    preg_match_all('/./us', $replacement, $replacement_array);

    array_splice($str_array[0], $offset, $length, $replacement_array[0]);
    return implode('', $str_array[0]);
}
