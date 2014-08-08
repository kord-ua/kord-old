<?php

namespace KORD\Helper;

/**
 * Encoding helper class.
 */
class EncodingSrc
{

    /**
     * @var  string  default encoding
     */
    public static $default = 'UTF-8';
    
    /**
     * @var array  The list of most popular encodings
     */
    public static $list = [
        'UTF-8', 'ISO-8859-1', 'Windows-1251', 'GB2312', 'Shift JIS', 
        'Windows-1252', 'GBK', 'EUC-JP', 'ISO-8859-2', 'EUC-KR', 'Windows-1256',
        'ISO-8859-15', 'ISO-8859-9', 'Windows-1250', 'Windows-1254', 'Big5',
        'Windows-874', 'US-ASCII'
        ];

    /**
     * Detect encoding of a string
     * 
     * @param string $string
     * @return string detected encoding
     */
    public static function detect($string)
    {
        if (extension_loaded('mbstring')) {
            $encoding = mb_detect_encoding($string);
            if ('ISO-8859-2' === $encoding AND preg_match('~[\x7F-\x9F\xBC]~', $string)) {
                $encoding = 'WINDOWS-1250';
            }
        } else {
            foreach (Encoding::$list as $item) {
                if (strcmp(@iconv($item, $item, $string), $string) == 0) {
                    return $item;
                }
            }
            return Encoding::$default;
        }
        
        return $encoding;
    }

}
