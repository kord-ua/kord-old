<?php

namespace KORD\Validation\Barcode;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */
class Gtin13Src extends AdapterAbstract
{

    /**
     * Returns the allowed barcode length
     *
     * @return int|array
     */
    public function getLength()
    {
        return 13;
    }
    
    /**
     * Returns the allowed characters
     *
     * @return int|string|array
     */
    public function getCharacters()
    {
        return '0123456789';
    }
    
    /**
     * Returns the checksum function name
     *
     * @return string
     */
    public function getChecksum()
    {
        return 'gtin';
    }

}
