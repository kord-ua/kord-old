<?php

/**
 * MySQLi database connection.
 */

namespace KORD\Database\Driver;

use KORD\Core;
use KORD\Database;
use KORD\Database\Exception as DatabaseException;
use KORD\Profiler;

class MySQLiSrc extends \KORD\Database
{

    // MySQLi uses no quoting for identifiers
    protected $identifier = '';
    
    // results column names
    protected $columnNames;

    /**
     * @var array
     */
    protected $paramTypeMap = [
        \PDO::PARAM_STR => 's',
        \PDO::PARAM_BOOL => 'i',
        \PDO::PARAM_NULL => 's',
        \PDO::PARAM_INT => 'i',
        \PDO::PARAM_LOB => 's'
    ];

    /**
     *
     * @var \mysqli 
     */
    protected $connection;

    public function __construct($name, array $config)
    {
        parent::__construct($name, $config);

        if (isset($this->config['identifier'])) {
            // Allow the identifier to be overloaded per-connection
            $this->identifier = (string) $this->config['identifier'];
        }
    }

    public function connect()
    {
        if ($this->connection) {
            return;
        }

        // Extract the connection parameters, adding required variabels
        extract($this->config['connection'] + [
            'hostname' => '',
            'username' => null,
            'password' => null,
            'database' => '',
        ]);

        // Clear the connection parameters for security
        unset($this->config['connection']);

        $this->connection = new \mysqli($hostname, $username, $password, $database);

        /* check connection */
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
    }

    public function disconnect()
    {
        $this->connection->close();
        // Destroy the object
        $this->connection = null;

        return parent::disconnect();
    }

    public function setCharset($charset)
    {
        // Make sure the database is connected
        $this->connect();

        $this->connection->set_charset($charset);
    }

    public function query($type, $sql, $sql_params = null, $as_object = false, array $params = null)
    {
        // Make sure the database is connected
        $this->connect();

        if (Core::$profiling) {
            // Benchmark this query for the current instance
            $benchmark = Profiler::start("Database ({$this->name})", $sql);
        }

        try {
            // substitute named placeholders with unnamed
            if ($c = preg_match_all('/(:\w+)/is', $sql, $matches)) {
                $bind_params = [''];
                $list = $matches[0];
                foreach ($list as $value) {
                    $sql = str_replace($value, '?', $sql);
                    $bind_params[0] .= $this->paramTypeMap[$sql_params[$value][1]];
                    $bind_params[] = & $sql_params[$value][0];
                }
            } elseif ($sql_params) {
                $bind_params = [''];
                foreach ($sql_params as $value) {
                    $bind_params[0] .= $this->paramTypeMap[$value[1]];
                    $bind_params[] = & $value[0];
                }
            }

            $result = $this->connection->prepare($sql);

            if (isset($bind_params)) {
                $ref = new \ReflectionClass('\mysqli_stmt');
                $method = $ref->getMethod("bind_param");
                $method->invokeArgs($result, $bind_params);
            }

            $result->execute();
        } catch (\mysqli_sql_exception $e) {
            if (isset($benchmark)) {
                // This benchmark is worthless
                Profiler::delete($benchmark);
            }

            // Convert the exception in a database exception
            throw new DatabaseException('{error} [ {query} ]', [
                'error' => $e->getMessage(),
                'query' => $sql
            ], $e->getCode());
        }

        if (isset($benchmark)) {
            Profiler::stop($benchmark);
        }

        // Set the last query
        $this->last_query = $sql;

        $rows = [];

        if ($type === Database::SELECT) {
            // Convert the result into an array
            $this->bindResult($result, $rows);
            if ($as_object === false) {
                $rows = $this->fetchAssoc($result, $rows);
            } elseif (is_string($as_object)) {
                $rows = $this->fetchObject($result, $rows, $as_object, $params);
            } else {
                $rows = $this->fetchObject($result, $rows, '\stdClass');
            }

            $result->close();
            // Return an iterator of results
            return new \KORD\Database\Result\Cached($rows, $sql, $sql_params, $as_object, $params);
        } elseif ($type === Database::INSERT) {
            // Return a list of insert id and rows created
            return [
                $this->connection->insert_id,
                $result->affected_rows,
            ];
        } else {
            // Return the number of rows affected
            return $result->affected_rows;
        }
    }

    protected function bindResult($stmt, &$refs)
    {
        $meta = $stmt->result_metadata();

        $columnNames = [];
        foreach ($meta->fetch_fields() as $col) {
            $columnNames[] = $col->name;
        }
        $meta->free();

        $this->columnNames = $columnNames;
        $rowBindedValues = array_fill(0, count($columnNames), null);

        $refs = [];
        foreach ($rowBindedValues as $key => &$value) {
            $refs[$key] = & $value;
        }

        call_user_func_array(array($stmt, 'bind_result'), $refs);
    }

    protected function fetchAssoc($stmt, &$refs)
    {
        $rows = [];
        while ($row = $stmt->fetch()) {
            $array = [];
            foreach ($refs as $key => $value) {
                $array[$key] = $value;
            }
            $rows[] = array_combine($this->columnNames, $array);
        }
        return $rows;
    }
    
    protected function fetchObject($stmt, &$refs, $class, $params = null)
    {
        $rows = [];
        // create a ReflectionClass only once
        if (is_array($params)) {
            $reflect  = new \ReflectionClass($class);
        }
        
        while ($row = $stmt->fetch()) {
            if (is_array($params)) {
                $object = $reflect->newInstanceArgs($params);
            } else {
                $object = new $class;
            }
            foreach ($refs as $key => $value) {
                $object->{$this->columnNames[$key]} = $value;
            }
            $rows[] = $object;
        }
        
        unset($reflect);
        
        return $rows;
    }

    public function begin($mode = null)
    {
        // Make sure the database is connected
        $this->connect();

        return $this->connection->begin_transaction();
    }

    public function commit()
    {
        // Make sure the database is connected
        $this->connect();

        return $this->connection->commit();
    }

    public function rollback()
    {
        // Make sure the database is connected
        $this->connect();

        return $this->connection->rollback();
    }

    public function escape($value)
    {
        // Make sure the database is connected
        $this->connect();

        return $this->connection->escape_string($value);
    }

}
