<?php

/**
 * \KORD\UTF8::strrev
 *
 * @copyright  (c) 2007–2014 Kohana Team
 * @copyright  (c) 2005 Harry Fuecks
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 */
function _strrev($str)
{
    if (\KORD\UTF8::isAscii($str)) {
        return strrev($str);
    }

    preg_match_all('/./us', $str, $matches);
    return implode('', array_reverse($matches[0]));
}
