<?php

/**
 * \KORD\UTF8::ltrim
 *
 * @copyright  (c) 2005 Harry Fuecks
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 */
function _ltrim($str, $charlist = null)
{
    if ($charlist === null) {
        return ltrim($str);
    }

    if (\KORD\UTF8::isAscii($charlist)) {
        return ltrim($str, $charlist);
    }

    $charlist = preg_replace('#[-\[\]:\\\\^/]#', '\\\\$0', $charlist);

    return preg_replace('/^[' . $charlist . ']+/u', '', $str);
}
