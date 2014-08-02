<?php

/**
 * Database query builder for UPDATE statements. See [Query Builder](/database/query/builder) for usage and examples.
 */

namespace KORD\Database\QueryBuilder;

use KORD\Database;

class UpdateSrc extends \KORD\Database\QueryBuilder\Where
{

    // UPDATE ...
    protected $table;
    // SET ...
    protected $set = [];

    /**
     * Set the table for a update.
     *
     * @param   mixed  $table  table name or array($table, $alias) or object
     * @return  void
     */
    public function __construct($table = null)
    {
        if ($table) {
            // Set the inital table name
            $this->table = $table;
        }

        // Start the query with no SQL
        return parent::__construct(Database::UPDATE, '');
    }

    /**
     * Sets the table to update.
     *
     * @param   mixed  $table  table name or array($table, $alias) or object
     * @return  $this
     */
    public function table($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Set the values to update with an associative array.
     *
     * @param   array   $pairs  associative (column => value) list
     * @return  $this
     */
    public function set(array $pairs)
    {
        foreach ($pairs as $column => $value) {
            $this->set[] = [$column, $value];
        }

        return $this;
    }

    /**
     * Set the value of a single column.
     *
     * @param   mixed  $column  table name or array($table, $alias) or object
     * @param   mixed  $value   column value
     * @return  $this
     */
    public function value($column, $value)
    {
        $this->set[] = [$column, $value];

        return $this;
    }

    /**
     * Compile the SQL query and return it.
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

        // Start an update query
        $query = 'UPDATE ' . $db->quoteTable($this->table);

        // Add the columns to update
        $query .= ' SET ' . $this->compileSet($db, $this->set);

        if (!empty($this->where)) {
            // Add selection conditions
            $query .= ' WHERE ' . $this->compileConditions($db, $this->where);
        }

        if (!empty($this->order_by)) {
            // Add sorting
            $query .= ' ' . $this->compileOrderBy($db, $this->order_by);
        }

        if ($this->limit !== null) {
            // Add limiting
            $query .= ' LIMIT ' . $this->limit;
        }

        $this->sql = $query;

        return parent::compile($db);
    }

    public function reset()
    {
        $this->table = null;

        $this->set = $this->where = [];

        $this->limit = null;

        $this->parameters = [];

        $this->sql = null;

        return $this;
    }

}
