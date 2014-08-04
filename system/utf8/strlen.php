<?php

/**
 * \KORD\UTF8::strlen
 *
 * @copyright  (c) 2007–2014 Kohana Team
 * @copyright  (c) 2005 Harry Fuecks
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 */
function _strlen($str)
{
    if (\KORD\UTF8::isAscii($str)) {
        return strlen($str);
    }

    return strlen(utf8_decode($str));
}
