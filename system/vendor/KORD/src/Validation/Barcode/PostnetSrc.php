<?php

namespace KORD\Validation\Barcode;

class PostnetSrc extends AdapterAbstract
{
    
    /**
     * Returns the allowed barcode length
     *
     * @return int|array
     */
    public function getLength()
    {
        return [6, 7, 10, 12];
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
        return 'postnet';
    }

}