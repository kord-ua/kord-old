<?php

namespace KORD\Helper\UTF8;

use KORD\Helper\UTF8;

/**
 * @copyright  (c) 2007–2014 Kohana Team
 * @copyright  (c) 2005 Harry Fuecks
 * @copyright  (c) 2014 Andriy Strepetov
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 */
class StringTransformSrc
{

    public static function transliterateToAscii($str, $case = 0)
    {
        static $utf8_lower_accents = null;
        static $utf8_upper_accents = null;

        if ($case <= 0) {
            if ($utf8_lower_accents === null) {
                $utf8_lower_accents = [
                    'à' => 'a', 'ô' => 'o', 'ď' => 'd', 'ḟ' => 'f', 'ë' => 'e', 'š' => 's', 'ơ' => 'o',
                    'ß' => 'ss', 'ă' => 'a', 'ř' => 'r', 'ț' => 't', 'ň' => 'n', 'ā' => 'a', 'ķ' => 'k',
                    'ŝ' => 's', 'ỳ' => 'y', 'ņ' => 'n', 'ĺ' => 'l', 'ħ' => 'h', 'ṗ' => 'p', 'ó' => 'o',
                    'ú' => 'u', 'ě' => 'e', 'é' => 'e', 'ç' => 'c', 'ẁ' => 'w', 'ċ' => 'c', 'õ' => 'o',
                    'ṡ' => 's', 'ø' => 'o', 'ģ' => 'g', 'ŧ' => 't', 'ș' => 's', 'ė' => 'e', 'ĉ' => 'c',
                    'ś' => 's', 'î' => 'i', 'ű' => 'u', 'ć' => 'c', 'ę' => 'e', 'ŵ' => 'w', 'ṫ' => 't',
                    'ū' => 'u', 'č' => 'c', 'ö' => 'o', 'è' => 'e', 'ŷ' => 'y', 'ą' => 'a', 'ł' => 'l',
                    'ų' => 'u', 'ů' => 'u', 'ş' => 's', 'ğ' => 'g', 'ļ' => 'l', 'ƒ' => 'f', 'ž' => 'z',
                    'ẃ' => 'w', 'ḃ' => 'b', 'å' => 'a', 'ì' => 'i', 'ï' => 'i', 'ḋ' => 'd', 'ť' => 't',
                    'ŗ' => 'r', 'ä' => 'a', 'í' => 'i', 'ŕ' => 'r', 'ê' => 'e', 'ü' => 'u', 'ò' => 'o',
                    'ē' => 'e', 'ñ' => 'n', 'ń' => 'n', 'ĥ' => 'h', 'ĝ' => 'g', 'đ' => 'd', 'ĵ' => 'j',
                    'ÿ' => 'y', 'ũ' => 'u', 'ŭ' => 'u', 'ư' => 'u', 'ţ' => 't', 'ý' => 'y', 'ő' => 'o',
                    'â' => 'a', 'ľ' => 'l', 'ẅ' => 'w', 'ż' => 'z', 'ī' => 'i', 'ã' => 'a', 'ġ' => 'g',
                    'ṁ' => 'm', 'ō' => 'o', 'ĩ' => 'i', 'ù' => 'u', 'į' => 'i', 'ź' => 'z', 'á' => 'a',
                    'û' => 'u', 'þ' => 'th', 'ð' => 'dh', 'æ' => 'ae', 'µ' => 'u', 'ĕ' => 'e', 'ı' => 'i',
                ];
            }

            $str = str_replace(
                    array_keys($utf8_lower_accents), array_values($utf8_lower_accents), $str
            );
        }

        if ($case >= 0) {
            if ($utf8_upper_accents === null) {
                $utf8_upper_accents = [
                    'À' => 'A', 'Ô' => 'O', 'Ď' => 'D', 'Ḟ' => 'F', 'Ë' => 'E', 'Š' => 'S', 'Ơ' => 'O',
                    'Ă' => 'A', 'Ř' => 'R', 'Ț' => 'T', 'Ň' => 'N', 'Ā' => 'A', 'Ķ' => 'K', 'Ĕ' => 'E',
                    'Ŝ' => 'S', 'Ỳ' => 'Y', 'Ņ' => 'N', 'Ĺ' => 'L', 'Ħ' => 'H', 'Ṗ' => 'P', 'Ó' => 'O',
                    'Ú' => 'U', 'Ě' => 'E', 'É' => 'E', 'Ç' => 'C', 'Ẁ' => 'W', 'Ċ' => 'C', 'Õ' => 'O',
                    'Ṡ' => 'S', 'Ø' => 'O', 'Ģ' => 'G', 'Ŧ' => 'T', 'Ș' => 'S', 'Ė' => 'E', 'Ĉ' => 'C',
                    'Ś' => 'S', 'Î' => 'I', 'Ű' => 'U', 'Ć' => 'C', 'Ę' => 'E', 'Ŵ' => 'W', 'Ṫ' => 'T',
                    'Ū' => 'U', 'Č' => 'C', 'Ö' => 'O', 'È' => 'E', 'Ŷ' => 'Y', 'Ą' => 'A', 'Ł' => 'L',
                    'Ų' => 'U', 'Ů' => 'U', 'Ş' => 'S', 'Ğ' => 'G', 'Ļ' => 'L', 'Ƒ' => 'F', 'Ž' => 'Z',
                    'Ẃ' => 'W', 'Ḃ' => 'B', 'Å' => 'A', 'Ì' => 'I', 'Ï' => 'I', 'Ḋ' => 'D', 'Ť' => 'T',
                    'Ŗ' => 'R', 'Ä' => 'A', 'Í' => 'I', 'Ŕ' => 'R', 'Ê' => 'E', 'Ü' => 'U', 'Ò' => 'O',
                    'Ē' => 'E', 'Ñ' => 'N', 'Ń' => 'N', 'Ĥ' => 'H', 'Ĝ' => 'G', 'Đ' => 'D', 'Ĵ' => 'J',
                    'Ÿ' => 'Y', 'Ũ' => 'U', 'Ŭ' => 'U', 'Ư' => 'U', 'Ţ' => 'T', 'Ý' => 'Y', 'Ő' => 'O',
                    'Â' => 'A', 'Ľ' => 'L', 'Ẅ' => 'W', 'Ż' => 'Z', 'Ī' => 'I', 'Ã' => 'A', 'Ġ' => 'G',
                    'Ṁ' => 'M', 'Ō' => 'O', 'Ĩ' => 'I', 'Ù' => 'U', 'Į' => 'I', 'Ź' => 'Z', 'Á' => 'A',
                    'Û' => 'U', 'Þ' => 'Th', 'Ð' => 'Dh', 'Æ' => 'Ae', 'İ' => 'I',
                ];
            }

            $str = str_replace(
                    array_keys($utf8_upper_accents), array_values($utf8_upper_accents), $str
            );
        }

        return $str;
    }

    public static function strrev($str)
    {
        if (UTF8::isAscii($str)) {
            return strrev($str);
        }

        preg_match_all('/./us', $str, $matches);
        return implode('', array_reverse($matches[0]));
    }

    public static function strSplit($str, $split_length = 1)
    {
        $split_length = (int) $split_length;

        if (UTF8::isAscii($str)) {
            return str_split($str, $split_length);
        }

        if ($split_length < 1) {
            return false;
        }

        if (UTF8::strlen($str) <= $split_length) {
            return [$str];
        }

        preg_match_all('/.{' . $split_length . '}|[^\x00]{1,' . $split_length . '}$/us', $str, $matches);

        return $matches[0];
    }

    public static function strPad($str, $final_str_length, $pad_str = ' ', $pad_type = STR_PAD_RIGHT)
    {
        if (UTF8::isAscii($str) AND UTF8::isAscii($pad_str)) {
            return str_pad($str, $final_str_length, $pad_str, $pad_type);
        }

        $str_length = UTF8::strlen($str);

        if ($final_str_length <= 0 OR $final_str_length <= $str_length) {
            return $str;
        }

        $pad_str_length = UTF8::strlen($pad_str);
        $pad_length = $final_str_length - $str_length;

        if ($pad_type == STR_PAD_RIGHT) {
            $repeat = ceil($pad_length / $pad_str_length);
            return UTF8::substr($str . str_repeat($pad_str, $repeat), 0, $final_str_length);
        }

        if ($pad_type == STR_PAD_LEFT) {
            $repeat = ceil($pad_length / $pad_str_length);
            return UTF8::substr(str_repeat($pad_str, $repeat), 0, floor($pad_length)) . $str;
        }

        if ($pad_type == STR_PAD_BOTH) {
            $pad_length /= 2;
            $pad_length_left = floor($pad_length);
            $pad_length_right = ceil($pad_length);
            $repeat_left = ceil($pad_length_left / $pad_str_length);
            $repeat_right = ceil($pad_length_right / $pad_str_length);

            $pad_left = UTF8::substr(str_repeat($pad_str, $repeat_left), 0, $pad_length_left);
            $pad_right = UTF8::substr(str_repeat($pad_str, $repeat_right), 0, $pad_length_right);
            return $pad_left . $str . $pad_right;
        }

        throw new Exception("UTF8::strPad: Unknown padding type ({$pad_type})");
    }

    public static function strIreplace($search, $replace, $str, & $count = null)
    {
        if (UTF8::isAscii($search) AND UTF8::isAscii($replace) AND UTF8::isAscii($str)) {
            return str_ireplace($search, $replace, $str, $count);
        }

        if (is_array($str)) {
            foreach ($str as $key => $val) {
                $str[$key] = UTF8::strIreplace($search, $replace, $val, $count);
            }
            return $str;
        }

        if (is_array($search)) {
            $keys = array_keys($search);

            foreach ($keys as $k) {
                if (is_array($replace)) {
                    if (array_key_exists($k, $replace)) {
                        $str = UTF8::strIreplace($search[$k], $replace[$k], $str, $count);
                    } else {
                        $str = UTF8::strIreplace($search[$k], '', $str, $count);
                    }
                } else {
                    $str = UTF8::strIreplace($search[$k], $replace, $str, $count);
                }
            }
            return $str;
        }

        $search = UTF8::strtolower($search);
        $str_lower = UTF8::strtolower($str);

        $total_matched_strlen = 0;
        $i = 0;

        while (preg_match('/(.*?)' . preg_quote($search, '/') . '/s', $str_lower, $matches)) {
            $matched_strlen = strlen($matches[0]);
            $str_lower = substr($str_lower, $matched_strlen);

            $offset = $total_matched_strlen + strlen($matches[1]) + ($i * (strlen($replace) - 1));
            $str = substr_replace($str, $replace, $offset, strlen($search));

            $total_matched_strlen += $matched_strlen;
            $i++;
        }

        $count += $i;
        return $str;
    }

}
