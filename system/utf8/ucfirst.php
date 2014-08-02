<?php

/**
 * \KORD\UTF8::ucfirst
 *
 * @copyright  (c) 2005 Harry Fuecks
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 */
function _ucfirst($str)
{
    if (\KORD\UTF8::isAscii($str)) {
        return ucfirst($str);
    }

    preg_match('/^(.?)(.*)$/us', $str, $matches);
    return \KORD\UTF8::strtoupper($matches[1]) . $matches[2];
}
