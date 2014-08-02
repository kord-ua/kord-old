<?php

namespace KORD\Validation\Barcode;

class Ean5Src extends AdapterAbstract
{

    /**
     * Returns the allowed barcode length
     *
     * @return int|array
     */
    public function getLength()
    {
        return 5;
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
     * Returns the use_checksum setting value
     *
     * @return bool
     */
    public function getUseChecksum()
    {
        return false;
    }

}
