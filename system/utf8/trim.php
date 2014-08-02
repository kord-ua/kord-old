<?php

/**
 * \KORD\UTF8::trim
 *
 * @copyright  (c) 2005 Harry Fuecks
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 */
function _trim($str, $charlist = null)
{
    if ($charlist === null) {
        return trim($str);
    }

    return \KORD\UTF8::ltrim(\KORD\UTF8::rtrim($str, $charlist), $charlist);
}
