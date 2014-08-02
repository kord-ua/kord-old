<?php

namespace KORD\Validation\Barcode;

class Code93extSrc extends AdapterAbstract
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
        return 128;
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
