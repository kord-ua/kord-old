<?php

/**
 * Interface for config writers
 *
 * Specifies the methods that a config writer must implement
 * 
 * @copyright  (c) 2007–2014 Kohana Team
 */

namespace KORD\Config;

use KORD\Config\SourceSrc as ConfigSourceSrc;

interface WriterSrc extends ConfigSourceSrc
{

    /**
     * Writes the passed config for $group
     *
     * Returns chainable instance on success or throws
     * \KORD\Exception on failure
     *
     * @param string      $group  The config group
     * @param array       $config The configuration to write
     * @return bool
     */
    public function write($group, $config);
}
