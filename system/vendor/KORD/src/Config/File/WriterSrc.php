<?php

/**
 * File-based configuration reader/writer. Multiple configuration directories 
 * can be used by attaching multiple instances of this class to [\KORD\Config].
 */

namespace KORD\Config\File;

use KORD\Config\WriterSrc as ConfigWriterSrc;
use KORD\Core;

class WriterSrc extends ReaderSrc implements ConfigWriterSrc
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
    public function write($group, $config)
    {
        $files = Core::findFile($this->directory, $group, null, true);

        if (!$files) {
            $files = [APPPATH . $this->directory . DS . $group . EXT];
        }

        foreach ($files as $file) {
            $contents = Core::FILE_SECURITY . PHP_EOL . PHP_EOL .
                    'return ' . var_export($config, true) . ';';
            file_put_contents($file, $contents);
            chmod($file, 0666);
        }
    }

}
