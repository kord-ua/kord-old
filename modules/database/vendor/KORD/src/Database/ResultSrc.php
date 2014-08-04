<?php

/**
 * Database result wrapper.  See [Results](/database/results) for usage and examples.
 * 
 * @copyright  (c) 2007–2014 Kohana Team
 */

namespace KORD\Database;

abstract class ResultSrc implements \Countable, \Iterator, \SeekableIterator, \ArrayAccess
{

    // Executed SQL for this result
    protected $query;
    // Params for the executed sql
    protected $params;
    // Raw result resource
    protected $result;
    // Total number of rows and current row
    protected $total_rows = 0;
    protected $current_row = 0;
    // Return rows as an object or associative array
    protected $as_object;
    // Parameters for __construct when using object results
    protected $object_params = null;

    /**
     * Sets the total number of rows and stores the result locally.
     *
     * @param   mixed   $result     query result
     * @param   string  $sql        SQL query
     * @param   mixed   $as_object
     * @param   array   $params
     * @return  void
     */
    public function __construct($result, $sql, $sql_params = null, $as_object = false, array $params = null)
    {
        // Store the result locally
        $this->result = $result;

        // Store the SQL locally
        $this->query = $sql;
        
        // Store the SQL params locally
        $this->params = $sql_params;

        if (is_object($as_object)) {
            // Get the object class name
            $as_object = get_class($as_object);
        }

        // Results as objects or associative arrays
        $this->as_object = $as_object;

        if ($params) {
            // Object constructor params
            $this->object_params = $params;
        }
    }

    /**
     * Result destruction cleans up all open result sets.
     *
     * @return  void
     */
    abstract public function __destruct();

    /**
     * Get a cached database result from the current result iterator.
     *
     *     $cachable = serialize($result->cached());
     *
     * @return  \KORD\Database\Result\Cached
     */
    public function cached()
    {
        return new \KORD\Database\Result\Cached($this->asArray(), $this->query, $this->params, $this->as_object);
    }

    /**
     * Return all of the rows in the result as an array.
     *
     *     // Indexed array of all rows
     *     $rows = $result->asArray();
     *
     *     // Associative array of rows by "id"
     *     $rows = $result->asArray('id');
     *
     *     // Associative array of rows, "id" => "name"
     *     $rows = $result->asArray('id', 'name');
     *
     * @param   string  $key    column for associative keys
     * @param   string  $value  column for values
     * @return  array
     */
    public function asArray($key = null, $value = null)
    {
        $results = [];

        if ($key === null AND $value === null) {
            // Indexed rows

            foreach ($this as $row) {
                $results[] = $row;
            }
        } elseif ($key === null) {
            // Indexed columns

            if ($this->as_object) {
                foreach ($this as $row) {
                    $results[] = $row->$value;
                }
            } else {
                foreach ($this as $row) {
                    $results[] = $row[$value];
                }
            }
        } elseif ($value === null) {
            // Associative rows

            if ($this->as_object) {
                foreach ($this as $row) {
                    $results[$row->$key] = $row;
                }
            } else {
                foreach ($this as $row) {
                    $results[$row[$key]] = $row;
                }
            }
        } else {
            // Associative columns

            if ($this->as_object) {
                foreach ($this as $row) {
                    $results[$row->$key] = $row->$value;
                }
            } else {
                foreach ($this as $row) {
                    $results[$row[$key]] = $row[$value];
                }
            }
        }

        $this->rewind();

        return $results;
    }

    /**
     * Return the named column from the current row.
     *
     *     // Get the "id" value
     *     $id = $result->get('id');
     *
     * @param   string  $name     column to get
     * @param   mixed   $default  default value if the column does not exist
     * @return  mixed
     */
    public function get($name, $default = null)
    {
        $row = $this->current();

        if ($this->as_object) {
            if (isset($row->$name)) {
                return $row->$name;
            }
        }
        else {
            if (isset($row[$name])) {
                return $row[$name];
            }
        }

        return $default;
    }

    /**
     * Implements [\Countable::count], returns the total number of rows.
     *
     *     echo count($result);
     *
     * @return  integer
     */
    public function count()
    {
        return $this->total_rows;
    }

    /**
     * Implements [\ArrayAccess::offsetExists], determines if row exists.
     *
     *     if (isset($result[10]))
     *     {
     *         // Row 10 exists
     *     }
     *
     * @param   int     $offset
     * @return  boolean
     */
    public function offsetExists($offset)
    {
        return ($offset >= 0 AND $offset < $this->total_rows);
    }

    /**
     * Implements [\ArrayAccess::offsetGet], gets a given row.
     *
     *     $row = $result[10];
     *
     * @param   int     $offset
     * @return  mixed
     */
    public function offsetGet($offset)
    {
        if (!$this->seek($offset)) {
            return null;
        }

        return $this->current();
    }

    /**
     * Implements [\ArrayAccess::offsetSet], throws an error.
     *
     * [!!] You cannot modify a database result.
     *
     * @param   int     $offset
     * @param   mixed   $value
     * @return  void
     * @throws  \KORD\Exception
     */
    final public function offsetSet($offset, $value)
    {
        throw new \KORD\Exception('Database results are read-only');
    }

    /**
     * Implements [\ArrayAccess::offsetUnset], throws an error.
     *
     * [!!] You cannot modify a database result.
     *
     * @param   int     $offset
     * @return  void
     * @throws  \KORD\Exception
     */
    final public function offsetUnset($offset)
    {
        throw new \KORD\Exception('Database results are read-only');
    }

    /**
     * Implements [\Iterator::key], returns the current row number.
     *
     *     echo key($result);
     *
     * @return  integer
     */
    public function key()
    {
        return $this->current_row;
    }

    /**
     * Implements [\Iterator::next], moves to the next row.
     *
     *     next($result);
     *
     * @return  $this
     */
    public function next()
    {
        ++$this->current_row;
        return $this;
    }

    /**
     * Implements [\Iterator::prev], moves to the previous row.
     *
     *     prev($result);
     *
     * @return  $this
     */
    public function prev()
    {
        --$this->current_row;
        return $this;
    }

    /**
     * Implements [\Iterator::rewind], sets the current row to zero.
     *
     *     rewind($result);
     *
     * @return  $this
     */
    public function rewind()
    {
        $this->current_row = 0;
        return $this;
    }

    /**
     * Implements [\Iterator::valid], checks if the current row exists.
     *
     * [!!] This method is only used internally.
     *
     * @return  boolean
     */
    public function valid()
    {
        return $this->offsetExists($this->current_row);
    }

}
