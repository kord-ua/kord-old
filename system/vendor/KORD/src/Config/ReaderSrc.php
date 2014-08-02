<?php

/**
 * Interface for config readers
 */

namespace KORD\Config;

use KORD\Config\SourceSrc as ConfigSourceSrc;

interface ReaderSrc extends ConfigSourceSrc
{

    /**
     * Tries to load the specified configuration group
     *
     * Returns false if group does not exist or an array if it does
     *
     * @param  string $group Configuration group
     * @return bool|array
     */
    public function load($group);
}
