<?php

namespace KORD\Database\Driver;

use KORD\Core;
use KORD\Database;
use KORD\Database\Exception as DatabaseException;
use KORD\Profiler;

/**
 * PDO database connection.
 * 
 * @copyright  (c) 2007–2014 Kohana Team
 */
class PDOSrc extends \KORD\Database
{

    // PDO uses no quoting for identifiers
    protected $identifier = '';

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
            'dsn' => '',
            'username' => null,
            'password' => null,
            'persistent' => false,
        ]);

        // Clear the connection parameters for security
        unset($this->config['connection']);

        // Force PDO to use exceptions for all errors
        $options[\PDO::ATTR_ERRMODE] = \PDO::ERRMODE_EXCEPTION;

        if (!empty($persistent)) {
            // Make the connection persistent
            $options[\PDO::ATTR_PERSISTENT] = true;
        }

        try {
            // Create a new PDO connection
            $this->connection = new \PDO($dsn, $username, $password, $options);
        } catch (\PDOException $e) {
            throw new DatabaseException('{error}', ['error' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Create or redefine a SQL aggregate function.
     *
     * [!!] Works only with SQLite
     *
     * @link http://php.net/manual/function.pdo-sqlitecreateaggregate
     *
     * @param   string      $name       Name of the SQL function to be created or redefined
     * @param   callback    $step       Called for each row of a result set
     * @param   callback    $final      Called after all rows of a result set have been processed
     * @param   integer     $arguments  Number of arguments that the SQL function takes
     *
     * @return  boolean
     */
    public function createAggregate($name, $step, $final, $arguments = -1)
    {
        $this->connect();

        return $this->connection->sqliteCreateAggregate(
                        $name, $step, $final, $arguments
        );
    }

    /**
     * Create or redefine a SQL function.
     *
     * [!!] Works only with SQLite
     *
     * @link http://php.net/manual/function.pdo-sqlitecreatefunction
     *
     * @param   string      $name       Name of the SQL function to be created or redefined
     * @param   callback    $callback   Callback which implements the SQL function
     * @param   integer     $arguments  Number of arguments that the SQL function takes
     *
     * @return  boolean
     */
    public function createFunction($name, $callback, $arguments = -1)
    {
        $this->connect();

        return $this->connection->sqliteCreateFunction(
                        $name, $callback, $arguments
        );
    }

    public function disconnect()
    {
        // Destroy the PDO object
        $this->connection = null;

        return parent::disconnect();
    }

    public function setCharset($charset)
    {
        // Make sure the database is connected
        $this->connect();

        // This SQL-92 syntax is not supported by all drivers
        $this->connection->exec('SET NAMES ' . $this->quote($charset));
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
            $result = $this->connection->prepare($sql);
            
            foreach ($sql_params as $key => $value) {
                $result->bindValue($key, $value[0], $value[1]);
            }
            
            $result->execute();
        } catch (\Exception $e) {
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

        if ($type === Database::SELECT) {
            // Convert the result into an array, as \PDOStatement::rowCount is not reliable
            if ($as_object === false) {
                $result->setFetchMode(\PDO::FETCH_ASSOC);
            } elseif (is_string($as_object)) {
                $result->setFetchMode(\PDO::FETCH_CLASS, $as_object, $params);
            } else {
                $result->setFetchMode(\PDO::FETCH_CLASS, '\stdClass');
            }

            $result = $result->fetchAll();

            // Return an iterator of results
            return new \KORD\Database\Result\Cached($result, $sql, $sql_params, $as_object, $params);
        } elseif ($type === Database::INSERT) {
            // Return a list of insert id and rows created
            return [
                $this->connection->lastInsertId(),
                $result->rowCount(),
            ];
        } else {
            // Return the number of rows affected
            return $result->rowCount();
        }
    }

    public function begin($mode = null)
    {
        // Make sure the database is connected
        $this->connect();

        return $this->connection->beginTransaction();
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

        return $this->connection->rollBack();
    }

    public function escape($value)
    {
        // Make sure the database is connected
        $this->connect();

        return $this->connection->quote($value);
    }

}
