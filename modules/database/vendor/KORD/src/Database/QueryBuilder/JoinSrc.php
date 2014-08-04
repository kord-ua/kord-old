<?php

/**
 * Database query builder for JOIN statements. See [Query Builder](/database/query/builder) for usage and examples.
 * 
 * @copyright  (c) 2007–2014 Kohana Team
 */

namespace KORD\Database\QueryBuilder;

use KORD\Database;

class JoinSrc extends \KORD\Database\QueryBuilder
{

    // Type of JOIN
    protected $type;
    // JOIN ...
    protected $table;
    // ON ...
    protected $on = [];
    // USING ...
    protected $using = [];

    /**
     * Creates a new JOIN statement for a table. Optionally, the type of JOIN
     * can be specified as the second parameter.
     *
     * @param   mixed   $table  column name or array($column, $alias) or object
     * @param   string  $type   type of JOIN: INNER, RIGHT, LEFT, etc
     * @return  void
     */
    public function __construct($table, $type = null)
    {
        // Set the table to JOIN on
        $this->table = $table;

        if ($type !== null) {
            // Set the JOIN type
            $this->type = (string) $type;
        }
    }

    /**
     * Adds a new condition for joining.
     *
     * @param   mixed   $c1  column name or array($column, $alias) or object
     * @param   string  $op  logic operator
     * @param   mixed   $c2  column name or array($column, $alias) or object
     * @return  $this
     */
    public function on($c1, $op, $c2)
    {
        if (!empty($this->using)) {
            throw new \KORD\Exception('JOIN ... ON ... cannot be combined with JOIN ... USING ...');
        }

        $this->on[] = [$c1, $op, $c2];

        return $this;
    }

    /**
     * Adds a new condition for joining.
     *
     * @param   string  $columns  column name
     * @return  $this
     */
    public function using($columns)
    {
        if (!empty($this->on)) {
            throw new \KORD\Exception('JOIN ... ON ... cannot be combined with JOIN ... USING ...');
        }

        $columns = func_get_args();

        $this->using = array_merge($this->using, $columns);

        return $this;
    }

    /**
     * Compile the SQL partial for a JOIN statement and return it.
     *
     * @param   mixed  $db  Database instance or name of instance
     * @return  string
     */
    public function compile($db = null)
    {
        if (!is_object($db)) {
            // Get the database instance
            $db = Database::instance($db);
        }

        if ($this->type) {
            $sql = strtoupper($this->type) . ' JOIN';
        } else {
            $sql = 'JOIN';
        }

        // Quote the table name that is being joined
        $sql .= ' ' . $db->quoteTable($this->table);

        if (!empty($this->using)) {
            // Quote and concat the columns
            $sql .= ' USING (' . implode(', ', array_map([$db, 'quoteColumn'], $this->using)) . ')';
        } else {
            $conditions = [];
            foreach ($this->on as $condition) {
                // Split the condition
                list($c1, $op, $c2) = $condition;

                if ($op) {
                    // Make the operator uppercase and spaced
                    $op = ' ' . strtoupper($op);
                }

                // Quote each of the columns used for the condition
                $conditions[] = $db->quoteColumn($c1) . $op . ' ' . $db->quoteColumn($c2);
            }

            // Concat the conditions "... AND ..."
            $sql .= ' ON (' . implode(' AND ', $conditions) . ')';
        }

        return $sql;
    }

    public function reset()
    {
        $this->type = $this->table = null;

        $this->on = [];
    }

}
