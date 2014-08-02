<?php

namespace KORD\Filtration;

use KORD\Filtration\Boolean;
use KORD\Filtration\Exception;

class BooleanSrc extends FilterAbstract
{

    const TYPE_BOOLEAN = 1;
    const TYPE_INTEGER = 2;
    const TYPE_FLOAT = 4;
    const TYPE_STRING = 8;
    const TYPE_ZERO_STRING = 16;
    const TYPE_EMPTY_ARRAY = 32;
    const TYPE_NULL = 64;
    const TYPE_PHP = 127;
    const TYPE_FALSE_STRING = 128;
    const TYPE_LOCALIZED = 256;
    const TYPE_ALL = 511;

    /**
     * @var array
     */
    protected $constants = [
        Boolean::TYPE_BOOLEAN => 'boolean',
        Boolean::TYPE_INTEGER => 'integer',
        Boolean::TYPE_FLOAT => 'float',
        Boolean::TYPE_STRING => 'string',
        Boolean::TYPE_ZERO_STRING => 'zero',
        Boolean::TYPE_EMPTY_ARRAY => 'array',
        Boolean::TYPE_NULL => 'null',
        Boolean::TYPE_PHP => 'php',
        Boolean::TYPE_FALSE_STRING => 'false',
        Boolean::TYPE_LOCALIZED => 'localized',
        Boolean::TYPE_ALL => 'all',
    ];

    /**
     * Filter options
     * 
     * @var array
     */
    protected $options = [
        'type' => Boolean::TYPE_PHP,
        'casting' => true,
        'translations' => [],
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

        if (!is_int($type) OR ( $type < 0) OR ( $type > Boolean::TYPE_ALL)) {
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
     * Set the working mode
     *
     * @param  bool $flag When true this filter works like cast
     *                       When false it recognises only true and false
     *                       and all other values are returned as is
     * @return $this
     */
    public function setCasting($flag = true)
    {
        $this->options['casting'] = (bool) $flag;
        return $this;
    }

    /**
     * Returns the casting option
     *
     * @return bool
     */
    public function getCasting()
    {
        return $this->options['casting'];
    }

    /**
     * @param  array|Traversable $translations
     * @throws \KORD\Filtration\Exception
     * @return $this
     */
    public function setTranslations($translations)
    {
        if (!is_array($translations) AND ! $translations instanceof \Traversable) {
            throw new Exception(sprintf(
                    '"%s" expects an array or Traversable; received "%s"', __METHOD__, (is_object($translations) ? get_class($translations) : gettype($translations))
            ));
        }

        foreach ($translations as $message => $flag) {
            $this->options['translations'][$message] = (bool) $flag;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getTranslations()
    {
        return $this->options['translations'];
    }

    /**
     * Defined by Zend\Filter\FilterInterface
     *
     * Returns a boolean representation of $value
     *
     * @param  string $value
     * @return string
     */
    public function filter($value)
    {
        $type = $this->getType();
        $casting = $this->getCasting();

        // LOCALIZED
        if ($type >= Boolean::TYPE_LOCALIZED) {
            $type -= Boolean::TYPE_LOCALIZED;
            if (is_string($value)) {
                if (isset($this->options['translations'][$value])) {
                    return (bool) $this->options['translations'][$value];
                }
            }
        }

        // FALSE_STRING ('false')
        if ($type >= Boolean::TYPE_FALSE_STRING) {
            $type -= Boolean::TYPE_FALSE_STRING;
            if (is_string($value) AND ( strtolower($value) == 'false')) {
                return false;
            }

            if (!$casting AND is_string($value) AND ( strtolower($value) == 'true')) {
                return true;
            }
        }

        // NULL (null)
        if ($type >= Boolean::TYPE_NULL) {
            $type -= Boolean::TYPE_NULL;
            if ($value === null) {
                return false;
            }
        }

        // EMPTY_ARRAY (array())
        if ($type >= Boolean::TYPE_EMPTY_ARRAY) {
            $type -= Boolean::TYPE_EMPTY_ARRAY;
            if (is_array($value) AND ( $value == [])) {
                return false;
            }
        }

        // ZERO_STRING ('0')
        if ($type >= Boolean::TYPE_ZERO_STRING) {
            $type -= Boolean::TYPE_ZERO_STRING;
            if (is_string($value) AND ( $value == '0')) {
                return false;
            }

            if (!$casting AND ( is_string($value)) AND ( $value == '1')) {
                return true;
            }
        }

        // STRING ('')
        if ($type >= Boolean::TYPE_STRING) {
            $type -= Boolean::TYPE_STRING;
            if (is_string($value) AND ( $value == '')) {
                return false;
            }
        }

        // FLOAT (0.0)
        if ($type >= Boolean::TYPE_FLOAT) {
            $type -= Boolean::TYPE_FLOAT;
            if (is_float($value) AND ( $value == 0.0)) {
                return false;
            }

            if (!$casting AND is_float($value) AND ( $value == 1.0)) {
                return true;
            }
        }

        // INTEGER (0)
        if ($type >= Boolean::TYPE_INTEGER) {
            $type -= Boolean::TYPE_INTEGER;
            if (is_int($value) AND ( $value == 0)) {
                return false;
            }

            if (!$casting AND is_int($value) AND ( $value == 1)) {
                return true;
            }
        }

        // BOOLEAN (false)
        if ($type >= Boolean::TYPE_BOOLEAN) {
            $type -= Boolean::TYPE_BOOLEAN;
            if (is_bool($value)) {
                return $value;
            }
        }

        if ($casting) {
            return true;
        }

        return $value;
    }

}
