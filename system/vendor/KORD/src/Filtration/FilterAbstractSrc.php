<?php

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace KORD\Filtration;

use KORD\Filtration\Exception;
use KORD\Helper\Arr;

abstract class FilterAbstractSrc implements \KORD\Filtration\FilterInterface
{

    /**
     * Filter options
     *
     * @var array
     */
    protected $options = [];
    
    /**
     * Abstract constructor for all filters
     * A filter should accept following parameters:
     *  - nothing e.g. Filter()
     *  - one or multiple scalar values f.e. Filter($first, $second, $third)
     *  - an asociative array e.g. Filter(['first' => $first, 'second' => $second, 'third' => $third])
     *  - an array e.g. Filter([$first, $second, $third])
     *  - an instance of Traversable e.g. Filter($config_instance)
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
     * Set filter options
     * 
     * @param  array|Traversable $options
     * @return self
     * @throws \KORD\Filtration\Exception
     */
    public function setOptions($options)
    {
        if (!is_array($options) AND !$options instanceof \Traversable) {
            throw new Exception(sprintf(
                    '"%s" expects an array or Traversable; received "%s"', __METHOD__, (is_object($options) ? get_class($options) : gettype($options))
            ));
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

        foreach ($options as $key => $value) {
            $setter = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (method_exists($this, $setter)) {
                $this->{$setter}($value);
            } elseif (array_key_exists($key, $this->options)) {
                $this->options[$key] = $value;
            } else {
                throw new Exception(sprintf(
                        'The option "%s" does not have a matching %s setter method or options[%s] array key', $key, $setter, $key
                ));
            }
        }
        return $this;
    }

    /**
     * Retrieve options representing object state
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Invoke filter as a command
     *
     * Proxies to {@link filter()}
     *
     * @param  mixed $value
     * @throws \KORD\Filtration\Exception If filtering $value is impossible
     * @return mixed
     */
    public function __invoke($value)
    {
        return $this->filter($value);
    }

}
