<?php

/**
 * \KORD\UTF8::stristr
 *
 * @copyright  (c) 2005 Harry Fuecks
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 */
function _stristr($str, $search)
{
    if (\KORD\UTF8::isAscii($str) AND \KORD\UTF8::isAscii($search)) {
        return stristr($str, $search);
    }

    if ($search == '') {
        return $str;
    }

    $str_lower = \KORD\UTF8::strtolower($str);
    $search_lower = \KORD\UTF8::strtolower($search);

    preg_match('/^(.*?)' . preg_quote($search_lower, '/') . '/s', $str_lower, $matches);

    if (isset($matches[1])) {
        return substr($str, strlen($matches[1]));
    }
    
    return false;
}
