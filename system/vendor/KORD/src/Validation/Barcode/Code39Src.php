<?php

namespace KORD\Validation\Barcode;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @copyright  (c) 2014 Andriy Strepetov
 */
class Code39Src extends AdapterAbstract
{
    
    /**
     * Allowed options for this adapter
     * @var array
     */
    protected $options = [
        'length' => null,
        'characters' => null,
        'checksum' => null,
        'use_checksum' => false, // false by default
    ];
    
    /**
     * @var array
     */
    protected $check = [
        '0' => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6,
        '7' => 7, '8' => 8, '9' => 9, 'A' => 10, 'B' => 11, 'C' => 12, 'D' => 13,
        'E' => 14, 'F' => 15, 'G' => 16, 'H' => 17, 'I' => 18, 'J' => 19, 'K' => 20,
        'L' => 21, 'M' => 22, 'N' => 23, 'O' => 24, 'P' => 25, 'Q' => 26, 'R' => 27,
        'S' => 28, 'T' => 29, 'U' => 30, 'V' => 31, 'W' => 32, 'X' => 33, 'Y' => 34,
        'Z' => 35, '-' => 36, '.' => 37, ' ' => 38, '$' => 39, '/' => 40, '+' => 41,
        '%' => 42,
    ];
    
    /**
     * Returns the allowed barcode length
     *
     * @return int|array
     */
    public function getLength()
    {
        return -1;
    }
    
    /**
     * Returns the allowed characters
     *
     * @return int|string|array
     */
    public function getCharacters()
    {
        return '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ -.$/+%';
    }
    
    /**
     * Returns the checksum function name
     *
     * @return string
     */
    public function getChecksum()
    {
        return 'code39';
    }

    /**
     * Validates the checksum (Modulo 43)
     *
     * @param  string $value The barcode to validate
     * @return bool
     */
    protected function code39($value)
    {
        $checksum = substr($value, -1, 1);
        $value = str_split(substr($value, 0, -1));
        $count = 0;
        foreach ($value as $char) {
            $count += $this->check[$char];
        }

        $mod = $count % 43;
        if ($mod == $this->check[$checksum]) {
            return true;
        }

        return false;
    }

}
