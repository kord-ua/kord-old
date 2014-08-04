<?php

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace KORD\Filtration;

use KORD\Filtration\Null;
use KORD\Filtration\Exception;

class NullSrc extends FilterAbstract
{

    const TYPE_BOOLEAN = 1;
    const TYPE_INTEGER = 2;
    const TYPE_EMPTY_ARRAY = 4;
    const TYPE_STRING = 8;
    const TYPE_ZERO_STRING = 16;
    const TYPE_FLOAT = 32;
    const TYPE_ALL = 63;

    /**
     * @var array
     */
    protected $constants = [
        Null::TYPE_BOOLEAN => 'boolean',
        Null::TYPE_INTEGER => 'integer',
        Null::TYPE_EMPTY_ARRAY => 'array',
        Null::TYPE_STRING => 'string',
        Null::TYPE_ZERO_STRING => 'zero',
        Null::TYPE_FLOAT => 'float',
        Null::TYPE_ALL => 'all',
    ];

    /**
     * @var array
     */
    protected $options = [
        'type' => Null::TYPE_ALL,
    ];

    /**
     * Set boolean types
     *
     * @param  int|array $type
     * @throws \KORD\Filtration\Exception
     * @return $this
     */
    public function setType($type = null)
    {
        if (is_array($type)) {
            $detected = 0;
            foreach ($type as $value) {
                if (is_int($value)) {
                    $detected += $value;
                } elseif (in_array($value, $this->constants)) {
                    $detected += array_search($value, $this->constants);
                }
            }

            $type = $detected;
        } elseif (is_string($type) AND in_array($type, $this->constants)) {
            $type = array_search($type, $this->constants);
        }

        if (!is_int($type) OR ($type < 0) OR ($type > Null::TYPE_ALL)) {
            throw new Exception(sprintf(
                    'Unknown type value "%s" (%s)', $type, gettype($type)
            ));
        }

        $this->options['type'] = $type;
        return $this;
    }

    /**
     * Returns defined boolean types
     *
     * @return int
     */
    public function getType()
    {
        return $this->options['type'];
    }

    /**
     * Defined by \KORD\Filtration\FilterInterface
     *
     * Returns null representation of $value, if value is empty and matches
     * types that should be considered null.
     *
     * @param  string $value
     * @return string
     */
    public function filter($value)
    {
        $type = $this->getType();

        // FLOAT (0.0)
        if ($type >= Null::TYPE_FLOAT) {
            $type -= Null::TYPE_FLOAT;
            if (is_float($value) AND ($value == 0.0)) {
                return null;
            }
        }

        // STRING ZERO ('0')
        if ($type >= Null::TYPE_ZERO_STRING) {
            $type -= Null::TYPE_ZERO_STRING;
            if (is_string($value) AND ($value == '0')) {
                return null;
            }
        }

        // STRING ('')
        if ($type >= Null::TYPE_STRING) {
            $type -= Null::TYPE_STRING;
            if (is_string($value) AND ($value == '')) {
                return null;
            }
        }

        // EMPTY_ARRAY ([])
        if ($type >= Null::TYPE_EMPTY_ARRAY) {
            $type -= Null::TYPE_EMPTY_ARRAY;
            if (is_array($value) AND ($value == [])) {
                return null;
            }
        }

        // INTEGER (0)
        if ($type >= Null::TYPE_INTEGER) {
            $type -= Null::TYPE_INTEGER;
            if (is_int($value) AND ($value == 0)) {
                return null;
            }
        }

        // BOOLEAN (false)
        if ($type >= Null::TYPE_BOOLEAN) {
            $type -= Null::TYPE_BOOLEAN;
            if (is_bool($value) AND ($value == false)) {
                return null;
            }
        }

        return $value;
    }

}
