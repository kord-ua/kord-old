<?php

/**
 * Wrapper for configuration arrays. Multiple configuration readers can be
 * attached to allow loading configuration from files, database, etc.
 *
 * Configuration directives cascade across config sources in the same way that
 * files cascade across the filesystem.
 *
 * Directives from sources high in the sources list will override ones from those
 * below them.
 */

namespace KORD;

use KORD\Arr;
use KORD\Config\Group as ConfigGroup;
use KORD\Config\ReaderSrc as ConfigReaderSrc;
use KORD\Config\SourceSrc as ConfigSourceSrc;
use KORD\Config\WriterSrc as ConfigWriterSrc;
use KORD\Exception;

class ConfigSrc
{

    // Configuration readers
    protected $sources = [];
    // Array of config groups
    protected $groups = [];

    /**
     * Attach a configuration reader. By default, the reader will be added as
     * the first used reader. However, if the reader should be used only when
     * all other readers fail, use `false` for the second parameter.
     *
     *     $config->attach($reader);        // Try first
     *     $config->attach($reader, false); // Try last
     *
     * @param   \KORD\Config\SourceSrc    $source instance
     * @param   bool                 $first  add the reader as the first used object
     * @return  $this
     */
    public function attach(ConfigSourceSrc $source, $first = true)
    {
        if ($first === true) {
            // Place the log reader at the top of the stack
            array_unshift($this->sources, $source);
        } else {
            // Place the reader at the bottom of the stack
            $this->sources[] = $source;
        }

        // Clear any cached groups
        $this->groups = [];

        return $this;
    }

    /**
     * Detach a configuration reader.
     *
     *     $config->detach($reader);
     *
     * @param   \KORD\Config\SourceSrc   $source instance
     * @return  $this
     */
    public function detach(ConfigSourceSrc $source)
    {
        if (($key = array_search($source, $this->sources)) !== false) {
            // Remove the writer
            unset($this->sources[$key]);
        }

        return $this;
    }

    /**
     * Load a configuration group. Searches all the config sources, merging all the
     * directives found into a single config group.  Any changes made to the config
     * in this group will be mirrored across all writable sources.
     *
     *     $array = $config->load($name);
     *
     * See [\KORD\Config\Group] for more info
     *
     * @param   string  $group  configuration group name
     * @return  \KORD\Config\Group
     * @throws  \KORD\Exception
     */
    public function load($group)
    {
        if (!count($this->sources)) {
            throw new Exception('No configuration sources attached');
        }

        if (empty($group)) {
            throw new Exception("Need to specify a config group");
        }

        if (!is_string($group)) {
            throw new Exception("Config group must be a string");
        }

        if (strpos($group, '.') !== false) {
            // Split the config group and path
            list($group, $path) = explode('.', $group, 2);
        }

        if (isset($this->groups[$group])) {
            if (isset($path)) {
                return Arr::path($this->groups[$group], $path, null, '.');
            }
            return $this->groups[$group];
        }

        $config = [];

        // We search from the "lowest" source and work our way up
        $sources = array_reverse($this->sources);

        foreach ($sources as $source) {
            if ($source instanceof ConfigReaderSrc) {
                if ($source_config = $source->load($group)) {
                    $config = Arr::merge($config, $source_config);
                }
            }
        }

        $this->groups[$group] = new ConfigGroup($this, $group, $config);

        if (isset($path)) {
            return Arr::path($config, $path, null, '.');
        }

        return $this->groups[$group];
    }

    /**
     * Copy one configuration group to all of the other writers.
     *
     *     $config->copy($name);
     *
     * @param   string  $group  configuration group name
     * @return  $this
     */
    public function copy($group)
    {
        // Load the configuration group
        $config = $this->load($group);
        
        $this->write($group, $config->asArray());

        return $this;
    }

    /**
     * Callback used by the config group to store changes made to configuration
     *
     * @param string    $group  Group name
     * @param array     $config The new config
     * @return $this    Chainable instance
     */
    public function write($group, $config)
    {
        foreach ($this->sources as $source) {
            if (!($source instanceof ConfigWriterSrc)) {
                continue;
            }

            // Copy each value in the config
            $source->write($group, $config);
        }

        return $this;
    }

}
