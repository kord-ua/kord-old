<?php

namespace KORD\Config\File;

use KORD\Config\ReaderSrc as ConfigReaderSrc;
use KORD\Core;
use KORD\Helper\Arr;

/**
 * File-based configuration reader. Multiple configuration directories can be
 * used by attaching multiple instances of this class to [\KORD\Config].
 * 
 * @copyright  (c) 2007–2014 Kohana Team
 */
class ReaderSrc implements ConfigReaderSrc
{

    /**
     * The directory where config files are located
     * @var string
     */
    protected $directory = '';

    /**
     * Creates a new file reader using the given directory as a config source
     *
     * @param string    $directory  Configuration directory to search
     */
    public function __construct($directory = 'config')
    {
        // Set the configuration directory name
        $this->directory = trim($directory, '/');
    }

    /**
     * Load and merge all of the configuration files in this group.
     *
     *     $config->load($name);
     *
     * @param   string  $group  configuration group name
     * @return  $this   current object
     * @uses    \KORD\Core::load
     */
    public function load($group)
    {
        $config = [];

        if ($files = Core::findFile($this->directory, $group, null, true)) {
            foreach ($files as $file) {
                // Merge each file to the configuration array
                $config = Arr::merge($config, Core::load($file));
            }
        }

        return $config;
    }

}
