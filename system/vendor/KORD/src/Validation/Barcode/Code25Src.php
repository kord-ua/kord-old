<?php

namespace KORD\Validation\Barcode;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @copyright  (c) 2014 Andriy Strepetov
 */
class Code25Src extends AdapterAbstract
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
        return '0123456789';
    }
    
    /**
     * Returns the checksum function name
     *
     * @return string
     */
    public function getChecksum()
    {
        return 'code25';
    }

}
