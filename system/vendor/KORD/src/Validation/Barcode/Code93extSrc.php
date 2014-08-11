<?php

namespace KORD\Validation\Barcode;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @copyright  (c) 2014 Andriy Strepetov
 */
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
