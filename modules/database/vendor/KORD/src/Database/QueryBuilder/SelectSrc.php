<?php

/**
 * Database query builder for SELECT statements. See [Query Builder](/database/query/builder) for usage and examples.
 */

namespace KORD\Database\QueryBuilder;

use KORD\Database;
use KORD\DB;

class SelectSrc extends \KORD\Database\QueryBuilder\Where
{

    // SELECT ...
    protected $select = [];
    // DISTINCT
    protected $distinct = false;
    // FROM ...
    protected $from = [];
    // JOIN ...
    protected $join = [];
    // GROUP BY ...
    protected $group_by = [];
    // HAVING ...
    protected $having = [];
    // OFFSET ...
    protected $offset = null;
    // UNION ...
    protected $union = [];
    // The last JOIN statement created
    protected $last_join;

    /**
     * Sets the initial columns to select from.
     *
     * @param   array  $columns  column list
     * @return  void
     */
    public function __construct(array $columns = null)
    {
        if (!empty($columns)) {
            // Set the initial columns
            $this->select = $columns;
        }

        // Start the query with no actual SQL statement
        parent::__construct(Database::SELECT, '');
    }

    /**
     * Enables or disables selecting only unique columns using "SELECT DISTINCT"
     *
     * @param   boolean  $value  enable or disable distinct columns
     * @return  $this
     */
    public function distinct($value)
    {
        $this->distinct = (bool) $value;

        return $this;
    }

    /**
     * Choose the columns to select from.
     *
     * @param   mixed  $columns  column name or array($column, $alias) or object
     * @return  $this
     */
    public function select($columns = null)
    {
        $columns = func_get_args();

        $this->select = array_merge($this->select, $columns);

        return $this;
    }

    /**
     * Choose the columns to select from, using an array.
     *
     * @param   array  $columns  list of column names or aliases
     * @return  $this
     */
    public function selectArray(array $columns)
    {
        $this->select = array_merge($this->select, $columns);

        return $this;
    }

    /**
     * Choose the tables to select "FROM ..."
     *
     * @param   mixed  $tables  list of table names or array($table, $alias) or objects
     * @return  $this
     */
    public function from($tables)
    {
        $tables = func_get_args();

        $this->from = array_merge($this->from, $tables);

        return $this;
    }

    /**
     * Adds addition tables to "JOIN ...".
     *
     * @param   mixed   $table  column name or array($column, $alias) or object
     * @param   string  $type   join type (LEFT, RIGHT, INNER, etc)
     * @return  $this
     */
    public function join($table, $type = null)
    {
        $this->join[] = $this->last_join = new \KORD\Database\QueryBuilder\Join($table, $type);

        return $this;
    }

    /**
     * Adds "ON ..." conditions for the last created JOIN statement.
     *
     * @param   mixed   $c1  column name or array($column, $alias) or object
     * @param   string  $op  logic operator
     * @param   mixed   $c2  column name or array($column, $alias) or object
     * @return  $this
     */
    public function on($c1, $op, $c2)
    {
        $this->last_join->on($c1, $op, $c2);

        return $this;
    }

    /**
     * Adds "USING ..." conditions for the last created JOIN statement.
     *
     * @param   string  $columns  column name
     * @return  $this
     */
    public function using($columns)
    {
        $columns = func_get_args();

        call_user_func_array([$this->last_join, 'using'], $columns);

        return $this;
    }

    /**
     * Creates a "GROUP BY ..." filter.
     *
     * @param   mixed   $columns  list of column names or array($column, $alias) or objects
     * @return  $this
     */
    public function groupBy($columns)
    {
        $columns = func_get_args();

        $this->group_by = array_merge($this->group_by, $columns);

        return $this;
    }

    /**
     * Alias of andHaving()
     *
     * @param   mixed   $column  column name or array($column, $alias) or object
     * @param   string  $op      logic operator
     * @param   mixed   $value   column value
     * @return  $this
     */
    public function having($column, $op, $value = null)
    {
        return $this->andHaving($column, $op, $value);
    }

    /**
     * Creates a new "AND HAVING" condition for the query.
     *
     * @param   mixed   $column  column name or array($column, $alias) or object
     * @param   string  $op      logic operator
     * @param   mixed   $value   column value
     * @return  $this
     */
    public function andHaving($column, $op, $value = null)
    {
        $this->having[] = ['AND' => [$column, $op, $value]];

        return $this;
    }

    /**
     * Creates a new "OR HAVING" condition for the query.
     *
     * @param   mixed   $column  column name or array($column, $alias) or object
     * @param   string  $op      logic operator
     * @param   mixed   $value   column value
     * @return  $this
     */
    public function orHaving($column, $op, $value = null)
    {
        $this->having[] = ['OR' => [$column, $op, $value]];

        return $this;
    }

    /**
     * Alias of andHavingOpen()
     *
     * @return  $this
     */
    public function havingOpen()
    {
        return $this->andHavingOpen();
    }

    /**
     * Opens a new "AND HAVING (...)" grouping.
     *
     * @return  $this
     */
    public function andHavingOpen()
    {
        $this->having[] = ['AND' => '('];

        return $this;
    }

    /**
     * Opens a new "OR HAVING (...)" grouping.
     *
     * @return  $this
     */
    public function orHavingOpen()
    {
        $this->having[] = ['OR' => '('];

        return $this;
    }

    /**
     * Closes an open "AND HAVING (...)" grouping.
     *
     * @return  $this
     */
    public function havingClose()
    {
        return $this->andHavingClose();
    }

    /**
     * Closes an open "AND HAVING (...)" grouping.
     *
     * @return  $this
     */
    public function andHavingClose()
    {
        $this->having[] = ['AND' => ')'];

        return $this;
    }

    /**
     * Closes an open "OR HAVING (...)" grouping.
     *
     * @return  $this
     */
    public function orHavingClose()
    {
        $this->having[] = ['OR' => ')'];

        return $this;
    }

    /**
     * Adds an other UNION clause.
     *
     * @param mixed $select  if string, it must be the name of a table. Else
     *  must be an instance of \KORD\Database\QueryBuilder\Select
     * @param boolean $all  decides if it's an UNION or UNION ALL clause
     * @return $this
     */
    public function union($select, $all = true)
    {
        if (is_string($select)) {
            $select = DB::select()->from($select);
        }
        
        if (!$select instanceof \KORD\Database\QueryBuilder\Select) {
            throw new \KORD\Exception('first parameter must be a string or an instance of \KORD\Database\QueryBuilder\Select');
        }
            
        $this->union[] = ['select' => $select, 'all' => $all];
        return $this;
    }

    /**
     * Start returning results after "OFFSET ..."
     *
     * @param   integer   $number  starting result number or null to reset
     * @return  $this
     */
    public function offset($number)
    {
        $this->offset = $number;

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

        // Callback to quote columns
        $quote_column = [$db, 'quoteColumn'];

        // Callback to quote tables
        $quote_table = [$db, 'quoteTable'];

        // Start a selection query
        $query = 'SELECT ';

        if ($this->distinct === true) {
            // Select only unique results
            $query .= 'DISTINCT ';
        }

        if (empty($this->select)) {
            // Select all columns
            $query .= '*';
        } else {
            // Select all columns
            $query .= implode(', ', array_unique(array_map($quote_column, $this->select)));
        }

        if (!empty($this->from)) {
            // Set tables to select from
            $query .= ' FROM ' . implode(', ', array_unique(array_map($quote_table, $this->from)));
        }

        if (!empty($this->join)) {
            // Add tables to join
            $query .= ' ' . $this->compileJoin($db, $this->join);
        }

        if (!empty($this->where)) {
            // Add selection conditions
            $query .= ' WHERE ' . $this->compileConditions($db, $this->where);
        }

        if (!empty($this->group_by)) {
            // Add grouping
            $query .= ' ' . $this->compileGroupBy($db, $this->group_by);
        }

        if (!empty($this->having)) {
            // Add filtering conditions
            $query .= ' HAVING ' . $this->compileConditions($db, $this->having);
        }

        if (!empty($this->order_by)) {
            // Add sorting
            $query .= ' ' . $this->compileOrderBy($db, $this->order_by);
        }

        if ($this->limit !== null) {
            // Add limiting
            $query .= ' LIMIT ' . $this->limit;
        }

        if ($this->offset !== null) {
            // Add offsets
            $query .= ' OFFSET ' . $this->offset;
        }

        if (!empty($this->union)) {
            foreach ($this->union as $u) {
                $query .= ' UNION ';
                if ($u['all'] === true) {
                    $query .= 'ALL ';
                }
                $query .= $u['select']->compile($db);
            }
        }

        $this->sql = $query;

        return parent::compile($db);
    }

    public function reset()
    {
        $this->select = $this->from = $this->join = $this->where = $this->group_by = $this->having = $this->order_by = $this->union = [];

        $this->distinct = false;

        $this->limit = $this->offset = $this->last_join = null;

        $this->parameters = [];

        $this->sql = null;

        return $this;
    }

}
