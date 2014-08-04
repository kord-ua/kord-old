<?php

/**
 * @copyright  (c) 2007–2014 Kohana Team
 */

namespace KORD\ORM;

use KORD\Arr;
use KORD\Core;
use KORD\Date;
use KORD\ORM\Exception as ORMException;

class CacheSrc
{

    protected static $instance;

    /**
     * Stores column information for ORM models
     * @var array
     */
    protected $column_cache = [];
    
    /**
     *
     * @var string 
     */
    protected $column_cache_key = 'orm.columns';

    /**
     * Initialization storage for ORM models
     * @var array
     */
    protected $init_cache = [];

    /**
     * 
     * @return \KORD\ORM\Cache
     */
    public static function instance()
    {
        if (empty(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }
    
    public function getColumnCache($object = null)
    {
        if (($cache = Core::cache($this->column_cache_key)) !== null) {
            $this->column_cache = $cache;
        }
        if (isset($object)) {
            return Arr::get($this->column_cache, $object, false);
        }
        return $this->column_cache;
    }
    
    public function setColumnCache($cache, $object = null)
    {
        if (isset($object)) {
            $this->column_cache[$object] = $cache;
            Core::cache($this->column_cache_key, Arr::merge(Core::cache($this->column_cache_key), [$object => $cache]), Date::YEAR);
        } else {
            if (is_array($cache) AND Arr::isAssoc($cache)) {
                $this->column_cache = $cache;
                Core::cache($this->column_cache_key, Arr::merge(Core::cache($this->column_cache_key), $cache), Date::YEAR);
            } else {
                throw new ORMException('Cache data should be an associative array if no object is set');
            }
        }
        
        return $this;
    }
    
    public function getInitCache($object = null)
    {
        if (isset($object)) {
            return Arr::get($this->init_cache, $object, false);
        }
        return $this->init_cache;
    }
    
    public function setInitCache($cache, $object = null)
    {
        if (isset($object)) {
            $this->init_cache[$object] = $cache;
        } else {
            $this->init_cache = $cache;
        }
        
        return $this;
    }

}
