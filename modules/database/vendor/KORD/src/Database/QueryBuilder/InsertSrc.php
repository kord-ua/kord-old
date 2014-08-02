<?php

/**
 * Database query builder for INSERT statements. See [Query Builder](/database/query/builder) for usage and examples.
 */

namespace KORD\Database\QueryBuilder;

use KORD\Database;
use KORD\Database\Query as DatabaseQuery;

class InsertSrc extends \KORD\Database\QueryBuilder
{

    // INSERT INTO ...
    protected $table;
    // (...)
    protected $columns = [];
    // VALUES (...)
    protected $values = [];

    /**
     * Set the table and columns for an insert.
     *
     * @param   mixed  $table    table name or array($table, $alias) or object
     * @param   array  $columns  column names
     * @return  void
     */
    public function __construct($table = null, array $columns = null)
    {
        if ($table) {
            // Set the inital table name
            $this->table = $table;
        }

        if ($columns) {
            // Set the column names
            $this->columns = $columns;
        }

        // Start the query with no SQL
        return parent::__construct(Database::INSERT, '');
    }

    /**
     * Sets the table to insert into.
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
     * Set the columns that will be inserted.
     *
     * @param   array  $columns  column names
     * @return  $this
     */
    public function columns(array $columns)
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * Adds or overwrites values. Multiple value sets can be added.
     *
     * @param   array   $values  values list
     * @param   ...
     * @return  $this
     */
    public function values(array $values)
    {
        if (!is_array($this->values)) {
            throw new \KORD\Exception('INSERT INTO ... SELECT statements cannot be combined with INSERT INTO ... VALUES');
        }

        // Get all of the passed values
        $values = func_get_args();

        $this->values = array_merge($this->values, $values);

        return $this;
    }

    /**
     * Use a sub-query to for the inserted values.
     *
     * @param   object  $query  \KORD\Database\Query of SELECT type
     * @return  $this
     */
    public function select(DatabaseQuery $query)
    {
        if ($query->type() !== Database::SELECT) {
            throw new \KORD\Exception('Only SELECT queries can be combined with INSERT queries');
        }

        $this->values = $query;

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

        // Start an insertion query
        $query = 'INSERT INTO ' . $db->quoteTable($this->table);

        // Add the column names
        $query .= ' (' . implode(', ', array_map([$db, 'quoteColumn'], $this->columns)) . ') ';

        if (is_array($this->values)) {
            // Callback for quoting values
            $quote = [$db, 'quote'];

            $groups = [];
            
            foreach ($this->values as $group) {
                foreach ($group as $offset => $value) {
                    if ((is_string($value) AND array_key_exists($value, $this->parameters)) === false) {
                        // Quote the value, it is not a parameter
                        $group[$offset] = $db->quote($value);
                    }
                }

                $groups[] = '(' . implode(', ', $group) . ')';
            }

            // Add the values
            $query .= 'VALUES ' . implode(', ', $groups);
        } else {
            // Add the sub-query
            $query .= (string) $this->values;
        }

        $this->sql = $query;

        return parent::compile($db);
    }

    public function reset()
    {
        $this->table = null;

        $this->columns = $this->values = [];

        $this->parameters = [];

        $this->sql = null;

        return $this;
    }

}
