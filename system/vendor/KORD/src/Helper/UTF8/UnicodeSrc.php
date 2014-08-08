<?php

namespace KORD\Helper\UTF8;

/**
 * @copyright  (c) 2007–2014 Kohana Team
 * @copyright  (c) 2005 Harry Fuecks
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 */
class UnicodeSrc
{

    public static function fromUnicode($arr)
    {
        ob_start();

        $keys = array_keys($arr);

        foreach ($keys as $k) {
            // ASCII range (including control chars)
            if (($arr[$k] >= 0) AND ( $arr[$k] <= 0x007f)) {
                echo chr($arr[$k]);
            }
            // 2 byte sequence
            elseif ($arr[$k] <= 0x07ff) {
                echo chr(0xc0 | ($arr[$k] >> 6));
                echo chr(0x80 | ($arr[$k] & 0x003f));
            }
            // Byte order mark (skip)
            elseif ($arr[$k] == 0xFEFF) {
                // nop -- zap the BOM
            }
            // Test for illegal surrogates
            elseif ($arr[$k] >= 0xD800 AND $arr[$k] <= 0xDFFF) {
                // Found a surrogate
                throw new Exception("UTF8::fromUnicode: Illegal surrogate at index: '{$k}', value: '{$arr[$k]}'");
            }
            // 3 byte sequence
            elseif ($arr[$k] <= 0xffff) {
                echo chr(0xe0 | ($arr[$k] >> 12));
                echo chr(0x80 | (($arr[$k] >> 6) & 0x003f));
                echo chr(0x80 | ($arr[$k] & 0x003f));
            }
            // 4 byte sequence
            elseif ($arr[$k] <= 0x10ffff) {
                echo chr(0xf0 | ($arr[$k] >> 18));
                echo chr(0x80 | (($arr[$k] >> 12) & 0x3f));
                echo chr(0x80 | (($arr[$k] >> 6) & 0x3f));
                echo chr(0x80 | ($arr[$k] & 0x3f));
            }
            // Out of range
            else {
                throw new Exception("UTF8::fromUnicode: Codepoint out of Unicode range at index: '{$k}', value: '{$arr[$k]}'");
            }
        }

        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    public static function toUnicode($str)
    {
        // Cached expected number of octets after the current octet until the beginning of the next UTF8 character sequence
        $m_state = 0;
        // Cached Unicode character
        $m_ucs4 = 0;
        // Cached expected number of octets in the current sequence
        $m_bytes = 1;

        $out = [];

        $len = strlen($str);

        for ($i = 0; $i < $len; $i++) {
            $in = ord($str[$i]);

            if ($m_state == 0) {
                // When m_state is zero we expect either a US-ASCII character or a multi-octet sequence.
                if (0 == (0x80 & $in)) {
                    // US-ASCII, pass straight through.
                    $out[] = $in;
                    $m_bytes = 1;
                } elseif (0xC0 == (0xE0 & $in)) {
                    // First octet of 2 octet sequence
                    $m_ucs4 = $in;
                    $m_ucs4 = ($m_ucs4 & 0x1F) << 6;
                    $m_state = 1;
                    $m_bytes = 2;
                } elseif (0xE0 == (0xF0 & $in)) {
                    // First octet of 3 octet sequence
                    $m_ucs4 = $in;
                    $m_ucs4 = ($m_ucs4 & 0x0F) << 12;
                    $m_state = 2;
                    $m_bytes = 3;
                } elseif (0xF0 == (0xF8 & $in)) {
                    // First octet of 4 octet sequence
                    $m_ucs4 = $in;
                    $m_ucs4 = ($m_ucs4 & 0x07) << 18;
                    $m_state = 3;
                    $m_bytes = 4;
                } elseif (0xF8 == (0xFC & $in)) {
                    /** First octet of 5 octet sequence.
                     *
                     * This is illegal because the encoded codepoint must be either
                     * (a) not the shortest form or
                     * (b) outside the Unicode range of 0-0x10FFFF.
                     * Rather than trying to resynchronize, we will carry on until the end
                     * of the sequence and let the later error handling code catch it.
                     * */
                    $m_ucs4 = $in;
                    $m_ucs4 = ($m_ucs4 & 0x03) << 24;
                    $m_state = 4;
                    $m_bytes = 5;
                } elseif (0xFC == (0xFE & $in)) {
                    // First octet of 6 octet sequence, see comments for 5 octet sequence.
                    $m_ucs4 = $in;
                    $m_ucs4 = ($m_ucs4 & 1) << 30;
                    $m_state = 5;
                    $m_bytes = 6;
                } else {
                    // Current octet is neither in the US-ASCII range nor a legal first octet of a multi-octet sequence.
                    trigger_error('UTF8::toUnicode: Illegal sequence identifier in UTF-8 at byte ' . $i, E_USER_WARNING);
                    return false;
                }
            } else {
                // When m_state is non-zero, we expect a continuation of the multi-octet sequence
                if (0x80 == (0xC0 & $in)) {
                    // Legal continuation
                    $shift = ($m_state - 1) * 6;
                    $tmp = $in;
                    $tmp = ($tmp & 0x0000003F) << $shift;
                    $m_ucs4 |= $tmp;

                    // End of the multi-octet sequence. mUcs4 now contains the final Unicode codepoint to be output
                    if (0 == --$m_state) {
                        // Check for illegal sequences and codepoints
                        // From Unicode 3.1, non-shortest form is illegal
                        if (((2 == $m_bytes) AND ( $m_ucs4 < 0x0080)) OR ( (3 == $m_bytes) AND ( $m_ucs4 < 0x0800)) OR ( (4 == $m_bytes) AND ( $m_ucs4 < 0x10000)) OR ( 4 < $m_bytes) OR
                                // From Unicode 3.2, surrogate characters are illegal
                                ( ($m_ucs4 & 0xFFFFF800) == 0xD800) OR
                                // Codepoints outside the Unicode range are illegal
                                ( $m_ucs4 > 0x10FFFF)) {
                            trigger_error('UTF8::toUnicode: Illegal sequence or codepoint in UTF-8 at byte ' . $i, E_USER_WARNING);
                            return false;
                        }

                        if (0xFEFF != $m_ucs4) {
                            // BOM is legal but we don't want to output it
                            $out[] = $m_ucs4;
                        }

                        // Initialize UTF-8 cache
                        $m_state = 0;
                        $m_ucs4 = 0;
                        $m_bytes = 1;
                    }
                } else {
                    // ((0xC0 & (*in) != 0x80) AND (m_state != 0))
                    // Incomplete multi-octet sequence
                    throw new Exception("UTF8::toUnicode: Incomplete multi-octet sequence in UTF-8 at byte '{$i}'");
                }
            }
        }

        return $out;
    }

}
