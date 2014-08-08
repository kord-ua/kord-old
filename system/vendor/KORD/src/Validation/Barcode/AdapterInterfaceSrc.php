<?php

namespace KORD\Validation\Barcode;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */
interface AdapterInterfaceSrc
{

    /**
     * Checks the length of a barcode
     *
     * @param  string $value  The barcode to check for proper length
     * @return bool
     */
    public function hasValidLength($value);

    /**
     * Checks for allowed characters within the barcode
     *
     * @param  string $value The barcode to check for allowed characters
     * @return bool
     */
    public function hasValidCharacters($value);

    /**
     * Validates the checksum
     *
     * @param string $value The barcode to check the checksum for
     * @return bool
     */
    public function hasValidChecksum($value);

    /**
     * Returns the allowed barcode length
     *
     * @return int|array
     */
    public function getLength();

    /**
     * Returns the allowed characters
     *
     * @return int|string|array
     */
    public function getCharacters();

    /**
     * Returns the checksum function name
     *
     * @return string
     */
    public function getChecksum();

    /**
     * Turns on/off the checksum validation
     * 
     * @return bool
     */
    public function getUseChecksum();

}
