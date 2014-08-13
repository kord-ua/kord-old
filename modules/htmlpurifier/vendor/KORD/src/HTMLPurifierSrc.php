<?php

namespace KORD;

/** 
 * [HTMLPurifier](http://htmlpurifier.org/) instances repository
 * 
 * @copyright  (c) 2014 Andriy Strepetov
 */
class HTMLPurifierSrc
{
    
    /**
     * @var  string  default instance name
     */
    public static $default = 'default';

    /**
     * @var  array  HTMLPurifier instances
     */
    protected static $instances = [];

    /**
     * Sets a new instance of HTMLPurifier
     *
     *     HTMLPurifier::setInstance('custom', ['foo' => 'bar']);
     *
     * @param   string  $name   HTMLPurifier instance name
     * @param   array   $config HTMLPurifier instance config
     */
    public static function setInstance($name, $config)
    {
        if ($name === null) {
            // Use the default instance name
            $name = HTMLPurifier::$default;
        }
        
        $purifier_config = \HTMLPurifier_Config::createDefault();
        if (is_array($config)) {
            $purifier_config->loadArray($config);
        } else {
            throw new \InvalidArgumentException('HTMLPurifier config should be an array');
        }
        
        // Create a new instance
        HTMLPurifier::$instances[$name] = new \HTMLPurifier($purifier_config);
    }

    /**
     * Returns an instance of HTMLPurifier.
     *
     *     $purifier = HTMLPurifier::getInstance();
     *
     * @param   string  $name   HTMLPurifier instance name
     * @return  \HTMLPurifier
     */
    public static function getInstance($name = null)
    {
        if ($name === null) {
            // Use the default instance name
            $name = HTMLPurifier::$default;
        }

        return HTMLPurifier::$instances[$name];
    }

}
