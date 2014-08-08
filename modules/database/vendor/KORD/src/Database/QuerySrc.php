<?php

namespace KORD\Database;

use KORD\Core;
use KORD\Database;

/**
 * Database query wrapper.  See [Parameterized Statements](database/query/parameterized) for usage and examples.
 * 
 * @copyright  (c) 2007–2014 Kohana Team
 */
class QuerySrc
{

    // Query type
    protected $type;
    // Execute the query during a cache hit
    protected $force_execute = false;
    // Cache lifetime
    protected $lifetime = null;
    // SQL statement
    protected $sql;
    // Quoted query parameters
    protected $parameters = [];
    // Return results as associative arrays or objects
    protected $as_object = false;
    // Parameters for __construct when using object results
    protected $object_params = [];

    /**
     * Creates a new SQL query of the specified type.
     *
     * @param   integer  $type  query type: \KORD\Database::SELECT, \KORD\Database::INSERT, etc
     * @param   string   $sql   query string
     * @return  void
     */
    public function __construct($type, $sql)
    {
        $this->type = $type;
        $this->sql = $sql;
    }

    /**
     * Return the SQL query string.
     *
     * @return  string
     */
    public function __toString()
    {
        try {
            // Return the SQL string
            return $this->compile(Database::instance());
        } catch (\Exception $e) {
            return \KORD\Exception::text($e);
        }
    }

    /**
     * Get the type of the query.
     *
     * @return  integer
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * Enables the query to be cached for a specified amount of time.
     *
     * @param   integer  $lifetime  number of seconds to cache, 0 deletes it from the cache
     * @param   boolean  whether or not to execute the query during a cache hit
     * @return  $this
     * @uses    \KORD\Core::$cache_life
     */
    public function cached($lifetime = null, $force = false)
    {
        if ($lifetime === null) {
            // Use the global setting
            $lifetime = Core::$cache_life;
        }

        $this->force_execute = $force;
        $this->lifetime = $lifetime;

        return $this;
    }

    /**
     * Returns results as associative arrays
     *
     * @return  $this
     */
    public function asAssoc()
    {
        $this->as_object = false;

        $this->object_params = [];

        return $this;
    }

    /**
     * Returns results as objects
     *
     * @param   string  $class  classname or true for stdClass
     * @param   array   $params
     * @return  $this
     */
    public function asObject($class = true, array $params = null)
    {
        $this->as_object = $class;

        if ($params) {
            // Add object parameters
            $this->object_params = $params;
        }

        return $this;
    }

    /**
     * Set the value of a parameter in the query.
     *
     * @param   string   $param  parameter key to replace
     * @param   mixed    $value  value to use
     * @return  $this
     */
    public function setParam($param, $value, $type = \PDO::PARAM_STR)
    {
        if (is_int($param) AND $param < 1) {
            throw new \KORD\Exception('Invalid parameter number: Columns/Parameters are 1-based');
        }
        // Add or overload a new parameter
        $this->parameters[$param] = [$value, $type];

        return $this;
    }

    /**
     * Bind a variable to a parameter in the query.
     *
     * @param   string  $param  parameter key to replace
     * @param   mixed   $var    variable to use
     * @return  $this
     */
    public function bindParam($param, & $var, $type = \PDO::PARAM_STR)
    {
        if (is_int($param) AND $param < 1) {
            throw new \KORD\Exception('Invalid parameter number: Columns/Parameters are 1-based');
        }
        // Bind a value to a variable
        $this->parameters[$param] = [& $var, $type];

        return $this;
    }

    /**
     * Add multiple parameters to the query.
     *
     * @param   array  $params  list of parameters
     * @return  $this
     */
    public function addParameters(array $params)
    {
        foreach ($params as $key => $value) {
            if (!isset($value[1])) {
                $params[$key][1] = \PDO::PARAM_STR;
            }
        }
        
        // Merge the new parameters in
        $this->parameters = $params + $this->parameters;
            
        // Parameters should start from 1
        if (array_key_exists(0, $this->parameters)) {
            array_unshift($this->parameters, ['', '']);
            unset($this->parameters[0]);
        }
        
        return $this;
    }

    /**
     * Compile the SQL query and return it.
     *
     * @param   mixed  $db  Database instance or name of instance (deprecate?)
     * @return  string
     */
    public function compile($db = null)
    {
        // just return the compiled SQL, parameters will be used on execute
        return $this->sql;
    }

    /**
     * Execute the current query on the given database.
     *
     * @param   mixed    $db  Database instance or name of instance
     * @param   string   result object classname, true for stdClass or false for array
     * @param   array    result object constructor arguments
     * @return  \KORD\Database\Result   for SELECT queries
     * @return  mixed    the insert id for INSERT queries
     * @return  integer  number of affected rows for all other queries
     */
    public function execute($db = null, $as_object = null, $object_params = null)
    {
        if (!is_object($db)) {
            // Get the database instance
            $db = Database::instance($db);
        }

        if ($as_object === null) {
            $as_object = $this->as_object;
        }

        if ($object_params === null) {
            $object_params = $this->object_params;
        }

        // Compile the SQL query
        $sql = $this->compile($db);
        
        $sql_params = $this->parameters;

        if ($this->lifetime !== null AND $this->type === Database::SELECT) {
            // Set the cache key based on the database instance name, SQL and params
            $cache_key = '\KORD\Database::query("' . $db . '", "' . $sql . '", "' . serialize($sql_params) . '")';

            // Read the cache first to delete a possible hit with lifetime <= 0
            if (($result = Core::cache($cache_key, null, $this->lifetime)) !== null
                    AND ! $this->force_execute) {
                // Return a cached result
                return new \KORD\Database\Result\Cached($result, $sql, $sql_params, $as_object, $object_params);
            }
        }

        // Execute the query
        $result = $db->query($this->type, $sql, $sql_params, $as_object, $object_params);

        if (isset($cache_key) AND $this->lifetime > 0) {
            // Cache the result array
            Core::cache($cache_key, $result->asArray(), $this->lifetime);
        }

        return $result;
    }

}
