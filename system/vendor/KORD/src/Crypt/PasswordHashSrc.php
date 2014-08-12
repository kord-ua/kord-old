<?php

namespace KORD\Crypt;

class PasswordHashSrc
{

    /**
     * @var  string  default instance name
     */
    public static $default = 'default';

    /**
     * @var  array  Hash class instances
     */
    protected static $instances = [];

    /**
     * Sets a new instance of PasswordHash. A type of mechanism must be
     * provided in $config
     *
     *     PasswordHash::setInstance('custom', ['type' => 'bcrypt']);
     *
     * @param   string  $name   PasswordHash instance name
     * @param   array   $config PasswordHash instance config
     */
    public static function setInstance($name, $config)
    {
        if ($name === null) {
            // Use the default instance name
            $name = PasswordHash::$default;
        }

        if (!isset($config['type'])) {
            // No PasswordHash mechanism type is provided!
            throw new \InvalidArgumentException("No PasswordHash mechanism type is defined in config for '{name}' PasswordHash instance", ['name' => $name]);
        }

        $class_name = '\\KORD\\Crypt\\PasswordHash\\' . ucfirst(strtolower($config['type']));
        // Create a new instance
        PasswordHash::$instances[$name] = new $class_name($config);
    }

    /**
     * Returns an instance of Hash.
     *
     *     $hash = PasswordHash::getInstance();
     *
     * @param   string  $name   PasswordHash instance name
     * @return  \KORD\Crypt\PasswordHash\PasswordHashInterface
     */
    public static function getInstance($name = null)
    {
        if ($name === null) {
            // Use the default instance name
            $name = PasswordHash::$default;
        }

        return PasswordHash::$instances[$name];
    }

}
