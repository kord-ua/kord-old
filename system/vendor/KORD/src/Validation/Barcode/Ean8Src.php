<?php

namespace KORD\Validation\Barcode;

class Ean8Src extends AdapterAbstract
{
    
    /**
     * Returns the allowed barcode length
     *
     * @return int|array
     */
    public function getLength()
    {
        return [7, 8];
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

    /**
     * Overrides parent hasValidLength
     *
     * @param string $value Value
     * @return bool
     */
    public function hasValidLength($value)
    {
        if (strlen($value) == 7) {
            $this->setUseChecksum(false);
        } else {
            $this->setUseChecksum(true);
        }

        return parent::hasValidLength($value);
    }

}