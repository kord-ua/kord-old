<?php

namespace KORD\Database\QueryBuilder;

use KORD\Database;

/**
 * Database query builder for DELETE statements. See [Query Builder](/database/query/builder) for usage and examples.
 * 
 * @copyright  (c) 2007–2014 Kohana Team
 * @copyright  (c) 2014 Andriy Strepetov
 */
class DeleteSrc extends \KORD\Database\QueryBuilder\Where
{

    // DELETE FROM ...
    protected $table;

    /**
     * Set the table for a delete.
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
        return parent::__construct(Database::DELETE, '');
    }

    /**
     * Sets the table to delete from.
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

        // Start a deletion query
        $query = 'DELETE FROM ' . $db->quoteTable($this->table);

        if (!empty($this->where)) {
            // Add deletion conditions
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
        $this->where = [];

        $this->parameters = [];

        $this->sql = null;

        return $this;
    }

}
