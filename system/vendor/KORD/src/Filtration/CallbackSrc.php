<?php

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace KORD\Filtration;

use KORD\Filtration\Exception;

class CallbackSrc extends FilterAbstract
{

    /**
     * @var array
     */
    protected $options = [
        'callback' => null,
        'callback_params' => []
    ];
    
    /**
     * Set filter options
     * 
     * @param  array|Traversable $options
     * @return self
     * @throws \KORD\Filtration\Exception
     */
    public function setOptions($options)
    {
        if (isset($options[0]) AND isset($options[1])
                AND is_callable([$options[0], $options[1]])) {
            $this->setCallback([$options[0], $options[1]]);
            if (isset($options[2])) {
                $this->setCallbackParams($options[2]);
            }
        } else {
            parent::setOptions($options);
        }
    }

    /**
     * Sets a new callback for this filter
     *
     * @param  callable $callback
     * @throws Exception\InvalidArgumentException
     * @return $this
     */
    public function setCallback($callback)
    {
        if (!is_callable($callback)) {
            throw new Exception(
            'Invalid parameter for callback: must be callable'
            );
        }

        $this->options['callback'] = $callback;
        return $this;
    }

    /**
     * Returns the set callback
     *
     * @return callable
     */
    public function getCallback()
    {
        return $this->options['callback'];
    }

    /**
     * Sets parameters for the callback
     *
     * @param  array $params
     * @return $this
     */
    public function setCallbackParams($params)
    {
        $this->options['callback_params'] = (array) $params;
        return $this;
    }

    /**
     * Get parameters for the callback
     *
     * @return array
     */
    public function getCallbackParams()
    {
        return $this->options['callback_params'];
    }

    /**
     * Calls the filter per callback
     *
     * @param  mixed $value Options for the set callable
     * @return mixed Result from the filter which was called
     */
    public function filter($value)
    {
        $params = (array) $this->options['callback_params'];
        array_unshift($params, $value);

        return call_user_func_array($this->options['callback'], $params);
    }

}
