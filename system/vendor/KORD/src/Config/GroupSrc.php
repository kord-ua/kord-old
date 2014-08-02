<?php

/**
 * The group wrapper acts as an interface to all the config directives
 * gathered from across the system.
 *
 * This is the object returned from \KORD\Config::load
 *
 * Any modifications to configuration items should be done through an instance of this object
 */

namespace KORD\Config;

use KORD\Config;

class GroupSrc extends \ArrayObject
{

    /**
     * Reference the config object that created this group
     * Used when updating config
     * @var \KORD\Config
     */
    protected $parent_instance = null;

    /**
     * The group this config is for
     * Used when updating config items
     * @var string
     */
    protected $group_name = '';

    /**
     * Constructs the group object.  Kohana_Config passes the config group
     * and its config items to the object here.
     *
     * @param \KORD\Config  $instance "Owning" instance of \KORD\Config
     * @param string         $group    The group name
     * @param array          $config   Group's config
     */
    public function __construct(Config $instance, $group, array $config = [])
    {
        $this->parent_instance = $instance;
        $this->group_name = $group;

        parent::__construct($config, \ArrayObject::ARRAY_AS_PROPS);
    }

    /**
     * Return the current group in serialized form.
     *
     *     echo $config;
     *
     * @return  string
     */
    public function __toString()
    {
        return serialize($this->getArrayCopy());
    }

    /**
     * Alias for getArrayCopy()
     *
     * @return array Array copy of the group's config
     */
    public function asArray()
    {
        return $this->getArrayCopy();
    }

    /**
     * Returns the config group's name
     *
     * @return string The group name
     */
    public function groupName()
    {
        return $this->group_name;
    }

    /**
     * Get a variable from the configuration or return the default value.
     *
     *     $value = $config->get($key);
     *
     * @param   string  $key        array key
     * @param   mixed   $default    default value
     * @return  mixed
     */
    public function get($key, $default = null)
    {
        return $this->offsetExists($key) ? $this->offsetGet($key) : $default;
    }

    /**
     * Sets a value in the configuration array.
     *
     *     $config->set($key, $new_value);
     *
     * @param   string  $key    array key
     * @param   mixed   $value  array value
     * @return  $this
     */
    public function set($key, $value)
    {
        $this->offsetSet($key, $value);

        return $this;
    }

    /**
     * Overrides ArrayObject::offsetSet()
     * This method is called when config is changed via
     *
     *     $config->var = 'asd';
     *
     *     // OR
     *
     *     $config['var'] = 'asd';
     *
     * @param string $key   The key of the config item we're changing
     * @param mixed  $value The new array value
     */
    public function offsetSet($key, $value)
    {
        parent::offsetSet($key, $value);
        
        $this->parent_instance->write($this->group_name, $this->asArray());
    }

}
