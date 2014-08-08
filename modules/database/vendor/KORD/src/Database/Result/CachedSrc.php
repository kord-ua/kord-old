<?php

namespace KORD\Database\Result;

/**
 * Object used for caching the results of select queries.  See [Results](/database/results#select-cached) for usage and examples.
 * 
 * @copyright  (c) 2007–2014 Kohana Team
 */
class CachedSrc extends \KORD\Database\Result
{

    public function __construct(array $result, $sql, $sql_params = null, $as_object = null)
    {
        parent::__construct($result, $sql, $sql_params, $as_object);

        // Find the number of rows in the result
        $this->total_rows = count($result);
    }

    public function __destruct()
    {
        // Cached results do not use resources
    }

    public function cached()
    {
        return $this;
    }

    public function seek($offset)
    {
        if ($this->offsetExists($offset)) {
            $this->current_row = $offset;

            return true;
        } else {
            return false;
        }
    }

    public function current()
    {
        // Return an array of the row
        return $this->valid() ? $this->result[$this->current_row] : null;
    }

}
