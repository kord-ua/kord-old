<?php

/**
 * \KORD\UTF8::strpos
 *
 * @copyright  (c) 2007–2014 Kohana Team
 * @copyright  (c) 2005 Harry Fuecks
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 */
function _strpos($str, $search, $offset = 0)
{
    $offset = (int) $offset;

    if (\KORD\UTF8::isAscii($str) AND \KORD\UTF8::isAscii($search)) {
        return strpos($str, $search, $offset);
    }

    if ($offset == 0) {
        $array = explode($search, $str, 2);
        return isset($array[1]) ? \KORD\UTF8::strlen($array[0]) : false;
    }

    $str = \KORD\UTF8::substr($str, $offset);
    $pos = \KORD\UTF8::strpos($str, $search);
    return ($pos === false) ? false : ($pos + $offset);
}
