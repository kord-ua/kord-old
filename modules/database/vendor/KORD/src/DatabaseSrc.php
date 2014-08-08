<?php

namespace KORD;

use KORD\Database;
use KORD\Exception;

/**
 * Database connection wrapper/helper.
 *
 * You may get a database instance using `\KORD\Database::instance('name')` 
 * where name is the [config](database/config) group.
 * 
 * @copyright  (c) 2007–2014 Kohana Team
 */
abstract class DatabaseSrc
{

    // Query types
    const SELECT = 1;
    const INSERT = 2;
    const UPDATE = 3;
    const DELETE = 4;

    /**
     * @var  string  default instance name
     */
    public static $default = 'default';

    /**
     * @var  array  Database instances
     */
    public static $instances = [];

    /**
     * Get a singleton Database instance. If configuration is not specified,
     * it will be loaded from the database configuration file using the same
     * group as the name.
     *
     *     // Load the default database
     *     $db = \KORD\Database::instance();
     *
     *     // Create a custom configured instance
     *     $db = \KORD\Database::instance('custom', $config);
     *
     * @param   string   $name    instance name
     * @param   array    $config  configuration parameters
     * @return  \KORD\Database
     */
    public static function instance($name = null, array $config = null)
    {
        if ($name === null) {
            // Use the default instance name
            $name = Database::$default;
        }

        if (!isset(Database::$instances[$name])) {
            if ($config === null) {
                // Load the configuration for this database
                $config = Core::$config->load('database')->$name;
            }

            if (!isset($config['type'])) {
                throw new Exception('Database type not defined in {name} configuration', ['name' => $name]);
            }

            // Set the driver class name
            $driver = '\\KORD\\Database\\Driver\\' . ucfirst($config['type']);

            // Create the database connection instance
            $driver = new $driver($name, $config);

            // Store the database instance
            Database::$instances[$name] = $driver;
        }

        return Database::$instances[$name];
    }

    /**
     * @var  string  the last query executed
     */
    public $last_query;
    // Character that is used to quote identifiers
    protected $identifier = '"';
    // Instance name
    protected $name;
    // Raw server connection
    protected $connection;
    // Configuration array
    protected $config;

    /**
     * Stores the database configuration locally and name the instance.
     *
     * [!!] This method cannot be accessed directly, you must use [Database::instance].
     *
     * @return  void
     */
    protected function __construct($name, array $config)
    {
        // Set the instance name
        $this->name = $name;

        // Store the config locally
        $this->config = $config;

        if (empty($this->config['table_prefix'])) {
            $this->config['table_prefix'] = '';
        }
    }

    /**
     * Disconnect from the database when the object is destroyed.
     *
     *     // Destroy the database instance
     *     unset(\KORD\Database::instances[(string) $db], $db);
     *
     * [!!] Calling `unset($db)` is not enough to destroy the database, as it
     * will still be stored in `Database::$instances`.
     *
     * @return  void
     */
    public function __destruct()
    {
        $this->disconnect();
    }

    /**
     * Returns the database instance name.
     *
     *     echo (string) $db;
     *
     * @return  string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Connect to the database. This is called automatically when the first
     * query is executed.
     *
     *     $db->connect();
     *
     * @throws  \KORD\Database\Exception
     * @return  void
     */
    abstract public function connect();

    /**
     * Disconnect from the database. This is called automatically by [\KORD\Database::__destruct].
     * Clears the database instance from [\KORD\Database::$instances].
     *
     *     $db->disconnect();
     *
     * @return  boolean
     */
    public function disconnect()
    {
        unset(Database::$instances[$this->name]);

        return true;
    }

    /**
     * Set the connection character set. This is called automatically by [\KORD\Database::connect].
     *
     *     $db->setCharset('utf8');
     *
     * @throws  \KORD\Database\Exception
     * @param   string   $charset  character set name
     * @return  void
     */
    abstract public function setCharset($charset);

    /**
     * Perform an SQL query of the given type.
     *
     *     // Make a SELECT query and use objects for results
     *     $db->query(\KORD\Database::SELECT, 'SELECT * FROM groups', true);
     *
     *     // Make a SELECT query and use "Application\Model\User" for the results
     *     $db->query(\KORD\Database::SELECT, 'SELECT * FROM users LIMIT 1', 'Application\Model\User');
     *
     * @param   integer  $type       \KORD\Database::SELECT, \KORD\Database::INSERT, etc
     * @param   string   $sql        SQL query
     * @param   array    $sql_params SQL query parameters
     * @param   mixed    $as_object  result object class string, true for stdClass, false for assoc array
     * @param   array    $params     object construct parameters for result class
     * @return  object   \KORD\Database\Result for SELECT queries
     * @return  array    list (insert id, row count) for INSERT queries
     * @return  integer  number of affected rows for all other queries
     */
    abstract public function query($type, $sql, $sql_params = null, $as_object = false, array $params = null);

    /**
     * Start a SQL transaction
     *
     *     // Start the transactions
     *     $db->begin();
     *
     *     try {
     *          \KORD\DB::insert('users')->values($user1)...
     *          \KORD\DB::insert('users')->values($user2)...
     *          // Insert successful commit the changes
     *          $db->commit();
     *     }
     *     catch (\KORD\Database\Exception $e)
     *     {
     *          // Insert failed. Rolling back changes...
     *          $db->rollback();
     *      }
     *
     * @param string $mode  transaction mode
     * @return  boolean
     */
    abstract public function begin($mode = null);

    /**
     * Commit the current transaction
     *
     *     // Commit the database changes
     *     $db->commit();
     *
     * @return  boolean
     */
    abstract public function commit();

    /**
     * Abort the current transaction
     *
     *     // Undo the changes
     *     $db->rollback();
     *
     * @return  boolean
     */
    abstract public function rollback();

    /**
     * Count the number of records in a table.
     *
     *     // Get the total number of records in the "users" table
     *     $count = $db->countRecords('users');
     *
     * @param   mixed    $table  table name string or array(query, alias)
     * @return  integer
     */
    public function countRecords($table)
    {
        // Quote the table name
        $table = $this->quoteTable($table);

        return $this->query(Database::SELECT, 'SELECT COUNT(*) AS total_row_count FROM ' . $table, false)
                        ->get('total_row_count');
    }

    /**
     * Return the table prefix defined in the current configuration.
     *
     *     $prefix = $db->tablePrefix();
     *
     * @return  string
     */
    public function tablePrefix()
    {
        return $this->config['table_prefix'];
    }

    /**
     * Quote a value for an SQL query.
     *
     *     $db->quote(null);   // 'NULL'
     *     $db->quote(10);     // 10
     *     $db->quote('fred'); // 'fred'
     *
     * Objects passed to this function will be converted to strings.
     * [Database_Expression] objects will be compiled.
     * [Database_Query] objects will be compiled and converted to a sub-query.
     * All other objects will be converted using the `__toString` method.
     *
     * @param   mixed   $value  any value to quote
     * @return  string
     * @uses    \KORD\Database::escape
     */
    public function quote($value)
    {
        if (!is_array($value) AND trim($value) === '?') {
            return '?';
        } elseif ($value === null) {
            return 'NULL';
        } elseif ($value === true) {
            return "'1'";
        } elseif ($value === false) {
            return "'0'";
        } elseif (is_object($value)) {
            if ($value instanceof \KORD\Database\Query) {
                // Create a sub-query
                return '(' . $value->compile($this) . ')';
            } elseif ($value instanceof \KORD\Database\Expression) {
                // Compile the expression
                return $value->compile($this);
            } else {
                // Convert the object to a string
                return $this->quote((string) $value);
            }
        } elseif (is_array($value)) {
            return '(' . implode(', ', array_map([$this, __FUNCTION__], $value)) . ')';
        } elseif (is_int($value)) {
            return (int) $value;
        } elseif (is_float($value)) {
            // Convert to non-locale aware float to prevent possible commas
            return sprintf('%F', $value);
        }

        return $this->escape($value);
    }

    /**
     * Quote a database column name and add the table prefix if needed.
     *
     *     $column = $db->quoteColumn($column);
     *
     * You can also use SQL methods within identifiers.
     *
     *     $column = $db->quoteColumn(\KORD\DB::expr('COUNT(`column`)'));
     *
     * Objects passed to this function will be converted to strings.
     * [\KORD\Database\Expression] objects will be compiled.
     * [\KORD\Database\Query] objects will be compiled and converted to a sub-query.
     * All other objects will be converted using the `__toString` method.
     *
     * @param   mixed   $column  column name or array(column, alias)
     * @return  string
     * @uses    \KORD\Database::quoteIdentifier
     * @uses    \KORD\Database::tablePrefix
     */
    public function quoteColumn($column)
    {
        // Identifiers are escaped by repeating them
        $escaped_identifier = $this->identifier . $this->identifier;

        if (is_array($column)) {
            list($column, $alias) = $column;
            $alias = str_replace($this->identifier, $escaped_identifier, $alias);
        }

        if ($column instanceof \KORD\Database\Query) {
            // Create a sub-query
            $column = '(' . $column->compile($this) . ')';
        } elseif ($column instanceof \KORD\Database\Expression) {
            // Compile the expression
            $column = $column->compile($this);
        } else {
            // Convert to a string
            $column = (string) $column;

            $column = str_replace($this->identifier, $escaped_identifier, $column);

            if ($column === '*') {
                return $column;
            } elseif (strpos($column, '.') !== false) {
                $parts = explode('.', $column);

                if ($prefix = $this->tablePrefix()) {
                    // Get the offset of the table name, 2nd-to-last part
                    $offset = count($parts) - 2;

                    // Add the table prefix to the table name
                    $parts[$offset] = $prefix . $parts[$offset];
                }

                foreach ($parts as & $part) {
                    if ($part !== '*') {
                        // Quote each of the parts
                        $part = $this->identifier . $part . $this->identifier;
                    }
                }

                $column = implode('.', $parts);
            } else {
                $column = $this->identifier . $column . $this->identifier;
            }
        }

        if (isset($alias)) {
            $column .= ' AS ' . $this->identifier . $alias . $this->identifier;
        }

        return $column;
    }

    /**
     * Quote a database table name and adds the table prefix if needed.
     *
     *     $table = $db->quoteTable($table);
     *
     * Objects passed to this function will be converted to strings.
     * [\KORD\Database\Expression] objects will be compiled.
     * [\KORD\Database\Query] objects will be compiled and converted to a sub-query.
     * All other objects will be converted using the `__toString` method.
     *
     * @param   mixed   $table  table name or array(table, alias)
     * @return  string
     * @uses    \KORD\Database::quoteIdentifier
     * @uses    \KORD\Database::tablePrefix
     */
    public function quoteTable($table)
    {
        // Identifiers are escaped by repeating them
        $escaped_identifier = $this->identifier . $this->identifier;

        if (is_array($table)) {
            list($table, $alias) = $table;
            $alias = str_replace($this->identifier, $escaped_identifier, $alias);
        }

        if ($table instanceof \KORD\Database\Query) {
            // Create a sub-query
            $table = '(' . $table->compile($this) . ')';
        } elseif ($table instanceof \KORD\Database\Expression) {
            // Compile the expression
            $table = $table->compile($this);
        } else {
            // Convert to a string
            $table = (string) $table;

            $table = str_replace($this->identifier, $escaped_identifier, $table);

            if (strpos($table, '.') !== false) {
                $parts = explode('.', $table);

                if ($prefix = $this->tablePrefix()) {
                    // Get the offset of the table name, last part
                    $offset = count($parts) - 1;

                    // Add the table prefix to the table name
                    $parts[$offset] = $prefix . $parts[$offset];
                }

                foreach ($parts as & $part) {
                    // Quote each of the parts
                    $part = $this->identifier . $part . $this->identifier;
                }

                $table = implode('.', $parts);
            } else {
                // Add the table prefix
                $table = $this->identifier . $this->tablePrefix() . $table . $this->identifier;
            }
        }

        if (isset($alias)) {
            // Attach table prefix to alias
            $table .= ' AS ' . $this->identifier . $this->tablePrefix() . $alias . $this->identifier;
        }

        return $table;
    }

    /**
     * Quote a database identifier
     *
     * Objects passed to this function will be converted to strings.
     * [\KORD\Database\Expression] objects will be compiled.
     * [\KORD\Database\Query] objects will be compiled and converted to a sub-query.
     * All other objects will be converted using the `__toString` method.
     *
     * @param   mixed   $value  any identifier
     * @return  string
     */
    public function quoteIdentifier($value)
    {
        // Identifiers are escaped by repeating them
        $escaped_identifier = $this->identifier . $this->identifier;

        if (is_array($value)) {
            list($value, $alias) = $value;
            $alias = str_replace($this->identifier, $escaped_identifier, $alias);
        }

        if ($value instanceof \KORD\Database\Query) {
            // Create a sub-query
            $value = '(' . $value->compile($this) . ')';
        } elseif ($value instanceof \KORD\Database\Expression) {
            // Compile the expression
            $value = $value->compile($this);
        } else {
            // Convert to a string
            $value = (string) $value;

            $value = str_replace($this->identifier, $escaped_identifier, $value);

            if (strpos($value, '.') !== false) {
                $parts = explode('.', $value);

                foreach ($parts as & $part) {
                    // Quote each of the parts
                    $part = $this->identifier . $part . $this->identifier;
                }

                $value = implode('.', $parts);
            } else {
                $value = $this->identifier . $value . $this->identifier;
            }
        }

        if (isset($alias)) {
            $value .= ' AS ' . $this->identifier . $alias . $this->identifier;
        }

        return $value;
    }

    /**
     * Sanitize a string by escaping characters that could cause an SQL
     * injection attack.
     *
     *     $value = $db->escape('any string');
     *
     * @param   string   $value  value to quote
     * @return  string
     */
    abstract public function escape($value);
}
