<?php

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace KORD\Validation;

class RangeSrc extends RuleAbstract
{

    /**
     * Options for the between validator
     *
     * @var array
     */
    protected $options = [
        'min' => null, // scalar, minimum border
        'max' => null, // scalar, maximum border
        'inclusive' => true, // boolean, Whether to do inclusive comparisons, allowing equivalence to min and/or max
        'step' => 1, // scalar, step
        'base_value' => 0 // scalar, base value to step from
    ];

    /**
     * Returns the min option
     *
     * @return mixed
     */
    public function getMin()
    {
        return $this->options['min'];
    }

    /**
     * Sets the min option
     *
     * @param  mixed $min
     * @return $this Provides a fluent interface
     */
    public function setMin($min)
    {
        $this->options['min'] = $min;
        return $this;
    }

    /**
     * Returns the max option
     *
     * @return mixed
     */
    public function getMax()
    {
        return $this->options['max'];
    }

    /**
     * Sets the max option
     *
     * @param  mixed $max
     * @return $this Provides a fluent interface
     */
    public function setMax($max)
    {
        $this->options['max'] = $max;
        return $this;
    }

    /**
     * Returns the inclusive option
     *
     * @return bool
     */
    public function getInclusive()
    {
        return $this->options['inclusive'];
    }

    /**
     * Sets the inclusive option
     *
     * @param  bool $inclusive
     * @return Between Provides a fluent interface
     */
    public function setInclusive($inclusive)
    {
        $this->options['inclusive'] = $inclusive;
        return $this;
    }

    /**
     * Returns the max option
     *
     * @return mixed
     */
    public function getStep()
    {
        return $this->options['step'];
    }

    /**
     * Sets the step option
     *
     * @param  mixed $step
     * @return $this Provides a fluent interface
     */
    public function setStep($step)
    {
        $this->options['step'] = $step;
        return $this;
    }
    
    /**
     * Returns the base value from which the step should be computed
     *
     * @return string
     */
    public function getBaseValue()
    {
        return $this->options['base_value'];
    }

    /**
     * Sets the base value from which the step should be computed
     *
     * @param mixed $base_value
     * @return $this
     */
    public function setBaseValue($base_value)
    {
        $this->options['base_value'] = $base_value;
        return $this;
    }

    /**
     * Returns true if and only if $value is between min and max options, inclusively
     * if inclusive option is true.
     *
     * @param  mixed $value
     * @return bool
     */
    public function isValid($value)
    {
        if (!is_numeric($value)) {
            $this->addError('typeInvalid');
            return false;
        }

        $fmod = $this->fmod($value - $this->getBaseValue(), $this->getStep());

        if ($fmod !== 0.0 && $fmod !== $this->getStep()) {
            $this->addError('stepInvalid');
            return false;
        }

        if ($this->getMin() !== null) {
            $min = $this->getMin();// + $this->getStep();
            $fmod = $this->fmod($this->getMin() - $this->getBaseValue(), $this->getStep());
            if ($fmod !== 0.0) {
                $min = $min - $fmod + $this->getStep();
            }
            if ($this->getInclusive()) {
                if ($value < $min) {
                    $this->addError('notGreaterThanInclusive', [':min' => $min]);
                    return false;
                }
            } else {
                if ($value <= $min) {
                    $this->addError('notGreaterThan', [':min' => $min]);
                    return false;
                }
            }
        }

        if ($this->getMax() !== null) {
            $max = $this->getMax() - $this->fmod($this->getMax() - $this->getBaseValue(), $this->getStep());
            if ($this->getInclusive()) {
                if ($value > $max) {
                    $this->addError('notLessThanInclusive', [':max' => $max]);
                    return false;
                }
            } else {
                if ($value >= $max) {
                    $this->addError('notLessThan', [':max' => $max]);
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * replaces the internal fmod function which give wrong results on many cases
     *
     * @param float $x
     * @param float $y
     * @return float
     */
    protected function fmod($x, $y)
    {
        if ($y == 0.0) {
            return 1.0;
        }

        //find the maximum precision from both input params to give accurate results
        $precision = strlen(substr($x, strpos($x, '.') + 1)) + strlen(substr($y, strpos($y, '.') + 1));

        return round($x - $y * floor($x / $y), $precision);
    }

}
