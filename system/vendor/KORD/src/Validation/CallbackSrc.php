<?php

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace KORD\Validation;

use KORD\Validation\Exception;

class CallbackSrc extends RuleAbstract
{
    
    /**
     * Default options to set for the validator
     *
     * @var mixed
     */
    protected $options = [
        'callback' => null, // Callback in a call_user_func format, string || array
        'callback_params' => [], // Params for the callback
    ];
    
    /**
     * Set filter options
     * 
     * @param  array|Traversable $options
     * @return self
     * @throws \KORD\Filtration\Exception
     */
    public function setOptions($options = [])
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
     * Returns the set callback
     *
     * @return mixed
     */
    public function getCallback()
    {
        return $this->options['callback'];
    }

    /**
     * Sets the callback
     *
     * @param  string|array|callable $callback
     * @return $this Provides a fluent interface
     * @throws \KORD\Validation\Exception
     */
    public function setCallback($callback)
    {
        if (!is_callable($callback)) {
            throw new Exception('Invalid callback given');
        }

        $this->options['callback'] = $callback;
        return $this;
    }

    /**
     * Returns the set params for the callback
     *
     * @return mixed
     */
    public function getCallbackParams()
    {
        return $this->options['callback_params'];
    }

    /**
     * Sets params for the callback
     *
     * @param  mixed $options
     * @return $this Provides a fluent interface
     */
    public function setCallbackParams($options)
    {
        $this->options['callback_params'] = (array) $options;
        return $this;
    }

    /**
     * Returns true if and only if the set callback returns true 
     * for the provided $value
     *
     * @param  mixed $value
     * @param  mixed $context Additional context to provide to the callback
     * @return bool
     * @throws \KORD\Validation\Exception
     */
    public function isValid($value, $context = null)
    {
        $params = $this->getCallbackParams();
        $callback = $this->getCallback();
        if (empty($callback)) {
            throw new Exception('No callback given');
        }

        $args = [$value];
        if (empty($params) AND !empty($context)) {
            $args[] = $context;
        }
        if (!empty($params) AND empty($context)) {
            $args = array_merge($args, $params);
        }
        if (!empty($params) AND !empty($context)) {
            $args[] = $context;
            $args = array_merge($args, $params);
        }

        try {
            if (!call_user_func_array($callback, $args)) {
                $this->addError('callbackInvalidValue');
                return false;
            }
        } catch (\Exception $e) {
            $this->addError('callbackInvalid');
            return false;
        }

        return true;
    }

}
