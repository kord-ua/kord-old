<?php

namespace KORD\Validation\Barcode;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */
class CodabarSrc extends AdapterAbstract
{
    
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
        return '0123456789-$:/.+';
    }
    
    /**
     * Returns the use_checksum setting value
     *
     * @return bool
     */
    public function getUseChecksum()
    {
        return false;
    }

    /**
     * Checks for allowed characters
     * @see KORD\Validation\Barcode\AdapterAbstract::hasValidCharacters()
     */
    public function hasValidCharacters($value)
    {
        if (strpbrk($value, 'ABCD')) {
            $first = $value[0];
            if (!strpbrk($first, 'ABCD')) {
                // Missing start char
                return false;
            }

            $last = substr($value, -1, 1);
            if (!strpbrk($last, 'ABCD')) {
                // Missing stop char
                return false;
            }

            $value = substr($value, 1, -1);
        } elseif (strpbrk($value, 'TN*E')) {
            $first = $value[0];
            if (!strpbrk($first, 'TN*E')) {
                // Missing start char
                return false;
            }

            $last = substr($value, -1, 1);
            if (!strpbrk($last, 'TN*E')) {
                // Missing stop char
                return false;
            }

            $value = substr($value, 1, -1);
        }
        
        return parent::hasValidCharacters($value);
    }

}
