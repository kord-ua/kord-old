<?php

namespace KORD;

use KORD\Core;
use KORD\Filtration;
use KORD\Filtration\FilterInterface;
use KORD\Helper\Arr;

class FiltrationSrc
{

    const APPEND = 'append';
    const PREPEND = 'prepend';

    /**
     * Filters
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Bound values
     *
     * @var array 
     */
    protected $bound = [];

    /**
     * Adds a filter to the set
     * 
     * @param string      $field  field name
     * @param callback    $filter valid PHP callback, Filter object or closure
     * @param array       $params extra parameters for the filter
     * @param boolean     $array_values  use this filter to filter array values?
     * @param  string     $placement
     * @return $this
     */
    public function addFilter($field, $filter, $params = null, $array_values = false, $placement = null)
    {
        if (is_string($filter) AND class_exists('\\KORD\\Filtration\\' . $filter)) {
            $class_name = '\\KORD\\Filtration\\' . $filter;
            $filter = new $class_name;
        }

        if (!is_array($params) AND ! is_null($params)) {
            $params = [$params];
        }

        // Store the filter and params for this filter
        $filter = [
            'filter' => $filter,
            'params' => $params,
            'array_values' => $array_values
        ];

        if ($placement == Filtration::PREPEND OR $placement === null) {
            $this->filters[$field][] = $filter;
        } else {
            array_unshift($this->filters[$field], $filter);
        }

        return $this;
    }

    /**
     * Add a filter to the end of the set
     *
     * @param string      $field  field name
     * @param callback    $filter valid PHP callback, Filter object or closure
     * @param array       $params extra parameters for the filter
     * @param boolean     $array_values  use this filter to filter array values?
     * @return $this      Provides a fluent interface
     */
    public function appendFilter($field, $filter, $params = null, $array_values = false)
    {
        return $this->addFilter($field, $filter, $params, $array_values, Filtration::APPEND);
    }

    /**
     * Add a filter to the start of the set
     *
     * @param string      $field  field name
     * @param callback    $filter valid PHP callback, Filter object or closure
     * @param array       $params extra parameters for the filter
     * @param boolean     $array_values  use this filter to filter array values?
     * @return $this      Provides a fluent interface
     */
    public function prependFilter($field, $filter, $params = null, $array_values = false)
    {
        return $this->addFilter($field, $filter, $params, $array_values, Filtration::PREPEND);
    }

    /**
     * Add filters using an array.
     *
     * @param   string  $field  field name
     * @param   array   $filters  list of callbacks
     * @return  $this
     */
    public function addFilters($field, array $filters)
    {
        foreach ($filters as $filter) {
            $this->addFilter($field, $filter[0], Arr::get($filter, 1), Arr::get($filter, 2, false), Arr::get($filter, 3, Filtration::APPEND));
        }

        return $this;
    }

    /**
     * Bind a value to a parameter definition.
     *
     *     // This allows you to use :model in the parameter definition of filters
     *     $validation->bind(':model', $model)
     *         ->addFilter('status', 'filterStatus', [':model']);
     *
     * @param   string  $key    variable name or an array of variables
     * @param   mixed   $value  value
     * @return  $this
     */
    public function bind($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $name => $value) {
                $this->bound[$name] = $value;
            }
        } else {
            $this->bound[$key] = $value;
        }

        return $this;
    }

    /**
     * Get all the filters
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Returns $array of values filtered through each filter in the set
     *
     * Filters are run in the order in which they were added to the set (FIFO)
     *
     * @param  mixed $array
     * @return mixed
     */
    public function filter($array)
    {
        if (Core::$profiling === true) {
            // Start a new benchmark
            $benchmark = Profiler::start('Validation', __FUNCTION__);
        }

        // Execute the filters
        foreach ($this->filters as $field => $set) {
            // Get the field value
            $initial_value = Arr::get($array, $field);

            // Bind the field name to :field
            $this->bind([':field' => $field]);

            foreach ($set as $arr) {
                // Filters are defined as associative array
                extract($arr);

                // Filter value as array if $array_values === true
                $values = ($array_values === false) ? [$initial_value] : $initial_value;

                foreach ($values as $key => $value) {
                    $filter_params = $params;

                    if ($filter_params === null) {
                        // Default to [':value']
                        $filter_params = [':value'];
                    }
                    
                    // Bind the value to :value
                    $this->bind([':value' => $value]);

                    foreach ($filter_params as $k => $param) {
                        if (is_string($param) AND array_key_exists($param, $this->bound)) {
                            // Replace with bound value
                            $filter_params[$k] = $this->bound[$param];
                        }
                    }

                    if ($filter instanceof FilterInterface) {
                        $filter_instance = clone $filter;
                        // set options using 3rd param of AddFilter
                        if (!empty($params)) {
                            $filter_instance->setOptions($filter_params);
                        }
                        $filtered = $filter->filter($value);
                    } elseif (is_array($filter)) {
                        // Allows filter('field', [':model', 'someFilter']);
                        if (is_string($filter[0]) AND array_key_exists($filter[0], $this->bound)) {
                            // Replace with bound value
                            $filter[0] = $this->bound[$filter[0]];
                        }
                        $filtered = call_user_func_array($filter, $filter_params);
                    } elseif (!is_string($filter)) {
                        // This is a lambda function
                        $filtered = call_user_func_array($filter, $filter_params);
                    } elseif (strpos($filter, '::') === false) {
                        // Use a function call
                        $function = new \ReflectionFunction($filter);

                        // Call $function($this[$field], $param, ...) with Reflection
                        $filtered = $function->invokeArgs($filter_params);
                    } else {
                        // Split the class and method of the filter
                        list($class, $method) = explode('::', $filter, 2);

                        // Use a static method call
                        $method = new \ReflectionMethod($class, $method);

                        // Call $Class::$method($this[$field], $param, ...) with Reflection
                        $filtered = $method->invokeArgs(null, $filter_params);
                    }

                    if ($array_values === true) {
                        $array[$field][$key] = $filtered;
                    } else {
                        $array[$field] = $filtered;
                    }
                }
            }
        }

        if (isset($benchmark)) {
            // Stop benchmarking
            Profiler::stop($benchmark);
        }

        return $array;
    }

}
