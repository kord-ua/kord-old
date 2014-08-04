<?php

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace KORD\Validation;

use KORD\Arr;
use KORD\Validation\Exception;

abstract class RuleAbstractSrc implements RuleInterface
{
    
    /**
     * Options for the rule
     *
     * @var array
     */
    protected $options = [];

    /**
     * Array of validation failure messages
     *
     * @var array
     */
    protected $errors = [];
    
    /**
     * Abstract constructor for all validators
     * A validator should accept following parameters:
     *  - nothing e.g. Validator()
     *  - one or multiple scalar values f.e. Validator($first, $second, $third)
     *  - an asociative array e.g. Validator(['first' => $first, 'second' => $second, 'third' => $third])
     *  - an array e.g. Validator([$first, $second, $third])
     *  - an instance of Traversable e.g. Validator($config_instance)
     * 
     * @param array|Traversable $options
     */
    public function __construct($options = null)
    {
        // The abstract constructor allows no scalar values
        if ($options instanceof \Traversable) {
            $options = iterator_to_array($options);
        }
        
        if (!is_array($options) OR func_num_args() > 1) {
            $options = func_get_args();
        }

        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    /**
     * Returns an option
     *
     * @param string $option Option to be returned
     * @return mixed Returned option
     * @throws \KORD\Validation\Exception
     */
    public function getOption($option)
    {
        if (isset($this->options) AND array_key_exists($option, $this->options)) {
            return $this->options[$option];
        }

        throw new Exception("Invalid option '$option'");
    }

    /**
     * Returns all available options
     *
     * @return array Array with all available options
     */
    public function getOptions()
    {
        return (isset($this->options) ? $this->options : []);
    }

    /**
     * Sets one or multiple options
     *
     * @param  array|Traversable $options Options to set
     * @throws \KORD\Validation\Exception If $options is not an array or Traversable
     * @return $this Provides fluid interface
     */
    public function setOptions($options = [])
    {
        if (!is_array($options) AND !$options instanceof \Traversable) {
            throw new Exception(__METHOD__ . ' expects an array or Traversable');
        }
        
        if ($options instanceof \Traversable) {
            $options = iterator_to_array($options);
        }
        
        if (!Arr::isAssoc($options)) {
            $temp = [];
            foreach ($this->options as $key => $value) {
                if (!empty($options)) {
                    $temp[$key] = ((count($this->options) > 1 OR count($options) == 1) ? array_shift($options) : $options);
                }
            }
            $options = $temp;
        }

        foreach ($options as $name => $option) {
            $fname = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $name)));
            $fname2 = 'use' . str_replace(' ', '', ucwords(str_replace('_', ' ', $name)));
            if (($name != 'setOptions') AND method_exists($this, $name)) {
                $this->{$name}($option);
            } elseif (($fname != 'setOptions') AND method_exists($this, $fname)) {
                $this->{$fname}($option);
            } elseif (method_exists($this, $fname2)) {
                $this->{$fname2}($option);
            } else {
                $this->options[$name] = $option;
            }
        }

        return $this;
    }
    
    /**
     * @param  string $message
     * @param  string $params      OPTIONAL
     * @return void
     */
    protected function addError($message, $params = [])
    {
        $this->errors[] = [$message, $params];
    }
    
    /**
     * Returns array of validation failure messages
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
    
    /**
     * Invoke as command
     *
     * @param  mixed $value
     * @return bool
     */
    public function __invoke($value)
    {
        return $this->isValid($value);
    }

}
