<?php

namespace KORD\Validation;

use KORD\Validation\Exception;
use KORD\Validation\NotEmpty;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */
class NotEmptySrc extends RuleAbstract
{

    const TYPE_BOOLEAN       = 0x001;
    const TYPE_INTEGER       = 0x002;
    const TYPE_FLOAT         = 0x004;
    const TYPE_STRING        = 0x008;
    const TYPE_ZERO          = 0x010;
    const TYPE_EMPTY_ARRAY   = 0x020;
    const TYPE_NULL          = 0x040;
    const TYPE_PHP           = 0x07F;
    const TYPE_SPACE         = 0x080;
    const TYPE_OBJECT        = 0x100;
    const TYPE_OBJECT_STRING = 0x200;
    const TYPE_OBJECT_COUNT  = 0x400;
    const TYPE_ALL           = 0x7FF;

    protected $constants = [
        NotEmpty::TYPE_BOOLEAN       => 'boolean',
        NotEmpty::TYPE_INTEGER       => 'integer',
        NotEmpty::TYPE_FLOAT         => 'float',
        NotEmpty::TYPE_STRING        => 'string',
        NotEmpty::TYPE_ZERO          => 'zero',
        NotEmpty::TYPE_EMPTY_ARRAY   => 'array',
        NotEmpty::TYPE_NULL          => 'null',
        NotEmpty::TYPE_PHP           => 'php',
        NotEmpty::TYPE_SPACE         => 'space',
        NotEmpty::TYPE_OBJECT        => 'object',
        NotEmpty::TYPE_OBJECT_STRING => 'objectstring',
        NotEmpty::TYPE_OBJECT_COUNT  => 'objectcount',
        NotEmpty::TYPE_ALL           => 'all',
    ];

    /**
     * Options for this validator
     * 
     * Default value for types = 493
     * 
     * NotEmpty::TYPE_OBJECT +
     * NotEmpty::TYPE_SPACE +
     * NotEmpty::TYPE_NULL +
     * NotEmpty::TYPE_EMPTY_ARRAY +
     * NotEmpty::TYPE_STRING +
     * NotEmpty::TYPE_FLOAT +
     * NotEmpty::TYPE_BOOLEAN
     *
     * @var array
     */
    protected $options = [
        'type' => 493
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
        if (is_array($options)) {
            if (!array_key_exists('type', $options)) {
                $detected = 0;
                $found    = false;
                foreach ($options as $option) {
                    if (in_array($option, $this->constants, true)) {
                        $found = true;
                        $detected += array_search($option, $this->constants);
                    }
                }

                if ($found) {
                    $options['type'] = $detected;
                }
            }
        }

        parent::setOptions($options);
    }

    /**
     * Returns the set types
     *
     * @return array
     */
    public function getType()
    {
        return $this->options['type'];
    }

    /**
     * Set the types
     *
     * @param  int|array $type
     * @throws \KORD\Validation\Exception
     * @return $this
     */
    public function setType($type = null)
    {
        $type = $this->calculateTypeValue($type);

        if (!is_int($type) OR ($type < 0) OR ($type > NotEmpty::TYPE_ALL)) {
            throw new Exception('Unknown type');
        }

        $this->options['type'] = $type;

        return $this;
    }

    /**
     * @param array|int|string $type
     * @return int
     */
    protected function calculateTypeValue($type)
    {
        if (is_array($type)) {
            $detected = 0;
            foreach ($type as $value) {
                if (is_int($value)) {
                    $detected |= $value;
                } elseif (in_array($value, $this->constants)) {
                    $detected |= array_search($value, $this->constants);
                }
            }

            $type = $detected;
        } elseif (is_string($type) AND in_array($type, $this->constants)) {
            $type = array_search($type, $this->constants);
        }

        return $type;
    }

    /**
     * Returns true if and only if $value is not an empty value.
     *
     * @param  string $value
     * @return bool
     */
    public function isValid($value)
    {
        if ($value !== null AND !is_string($value) AND !is_int($value) AND !is_float($value) AND
            !is_bool($value) AND !is_array($value) AND !is_object($value)
        ) {
            $this->addError('notEmptyInvalid');
            return false;
        }

        $type    = $this->getType();
        $object  = false;

        // TYPE_OBJECT_COUNT (countable object)
        if ($type & NotEmpty::TYPE_OBJECT_COUNT) {
            $object = true;

            if (is_object($value) AND ($value instanceof \Countable) AND (count($value) == 0)) {
                $this->addError('isEmpty');
                return false;
            }
        }

        // TYPE_OBJECT_STRING (object's toString)
        if ($type & NotEmpty::TYPE_OBJECT_STRING) {
            $object = true;

            if ((is_object($value) AND (!method_exists($value, '__toString'))) OR
                (is_object($value) AND (method_exists($value, '__toString')) AND (((string) $value) == ""))) {
                $this->addError('isEmpty');
                return false;
            }
        }

        // TYPE_OBJECT (object)
        if ($type & NotEmpty::TYPE_OBJECT) {
            // fall trough, objects are always not empty
        } elseif ($object === false) {
            // object not allowed but object given -> return false
            if (is_object($value)) {
                $this->addError('isEmpty');
                return false;
            }
        }

        // TYPE_SPACE ('   ')
        if ($type & NotEmpty::TYPE_SPACE) {
            if (is_string($value) AND (preg_match('/^\s+$/s', $value))) {
                $this->addError('isEmpty');
                return false;
            }
        }

        // TYPE_NULL (null)
        if ($type & NotEmpty::TYPE_NULL) {
            if ($value === null) {
                $this->addError('isEmpty');
                return false;
            }
        }

        // TYPE_EMPTY_ARRAY ([])
        if ($type & NotEmpty::TYPE_EMPTY_ARRAY) {
            if (is_array($value) AND ($value == [])) {
                $this->addError('isEmpty');
                return false;
            }
        }

        // TYPE_ZERO ('0')
        if ($type & NotEmpty::TYPE_ZERO) {
            if (is_string($value) AND ($value == '0')) {
                $this->addError('isEmpty');
                return false;
            }
        }

        // TYPE_STRING ('')
        if ($type & NotEmpty::TYPE_STRING) {
            if (is_string($value) AND ($value == '')) {
                $this->addError('isEmpty');
                return false;
            }
        }

        // TYPE_FLOAT (0.0)
        if ($type & NotEmpty::TYPE_FLOAT) {
            if (is_float($value) AND ($value == 0.0)) {
                $this->addError('isEmpty');
                return false;
            }
        }

        // TYPE_INTEGER (0)
        if ($type & NotEmpty::TYPE_INTEGER) {
            if (is_int($value) AND ($value == 0)) {
                $this->addError('isEmpty');
                return false;
            }
        }

        // TYPE_BOOLEAN (false)
        if ($type & NotEmpty::TYPE_BOOLEAN) {
            if (is_bool($value) AND ($value == false)) {
                $this->addError('isEmpty');
                return false;
            }
        }

        return true;
    }

}
