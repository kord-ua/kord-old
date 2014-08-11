<?php

namespace KORD\Validation\Barcode;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @copyright  (c) 2014 Andriy Strepetov
 */
class IssnSrc extends AdapterAbstract
{
    
    /**
     * Returns the allowed barcode length
     *
     * @return int|array
     */
    public function getLength()
    {
        return [8, 13];
    }
    
    /**
     * Returns the allowed characters
     *
     * @return int|string|array
     */
    public function getCharacters()
    {
        return '0123456789X';
    }

    /**
     * Allows X on length of 8 chars
     *
     * @param  string $value The barcode to check for allowed characters
     * @return bool
     */
    public function hasValidCharacters($value)
    {
        if (strlen($value) != 8 AND strpos($value, 'X') !== false) {
            return false;
        }

        return parent::hasValidCharacters($value);
    }

    /**
     * Validates the checksum
     *
     * @param  string $value The barcode to check the checksum for
     * @return bool
     */
    public function hasValidChecksum($value)
    {
        if (strlen($value) == 8) {
            $this->setChecksum('issn');
        } else {
            $this->setChecksum('gtin');
        }

        return parent::hasValidChecksum($value);
    }

    /**
     * Validates the checksum ()
     * ISSN implementation (reversed mod11)
     *
     * @param  string $value The barcode to validate
     * @return bool
     */
    protected function issn($value)
    {
        $checksum = substr($value, -1, 1);
        $values = str_split(substr($value, 0, -1));
        $check = 0;
        $multi = 8;
        foreach ($values as $token) {
            if ($token == 'X') {
                $token = 10;
            }

            $check += ($token * $multi);
            --$multi;
        }

        $check %= 11;
        $check = ($check === 0 ? 0 : (11 - $check));
        if ($check == $checksum) {
            return true;
        } elseif (($check == 10) && ($checksum == 'X')) {
            return true;
        }

        return false;
    }

}
