<?php

namespace KORD\Filtration;

use KORD\Filtration\Exception;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @copyright  (c) 2014 Andriy Strepetov
 */
class PregReplaceSrc extends FilterAbstract
{

    protected $options = [
        'pattern' => null,
        'replacement' => '',
    ];

    /**
     * Set the regex pattern to search for
     * @see preg_replace()
     *
     * @param  string|array $pattern - same as the first argument of preg_replace
     * @return $this
     * @throws \KORD\Filtration\Exception
     */
    public function setPattern($pattern)
    {
        if (!is_array($pattern) AND !is_string($pattern)) {
            throw new Exception(sprintf(
                    '%s expects pattern to be array or string; received "%s"', __METHOD__, (is_object($pattern) ? get_class($pattern) : gettype($pattern))
            ));
        }

        if (is_array($pattern)) {
            foreach ($pattern as $p) {
                $this->validatePattern($p);
            }
        }

        if (is_string($pattern)) {
            $this->validatePattern($pattern);
        }

        $this->options['pattern'] = $pattern;
        return $this;
    }

    /**
     * Get currently set match pattern
     *
     * @return string|array
     */
    public function getPattern()
    {
        return $this->options['pattern'];
    }

    /**
     * Set the replacement array/string
     * @see preg_replace()
     *
     * @param  array|string $replacement - same as the second argument of preg_replace
     * @return $this
     * @throws \KORD\Filtration\Exception
     */
    public function setReplacement($replacement)
    {
        if (!is_array($replacement) AND !is_string($replacement)) {
            throw new Exception(sprintf(
                    '%s expects replacement to be array or string; received "%s"', __METHOD__, (is_object($replacement) ? get_class($replacement) : gettype($replacement))
            ));
        }
        $this->options['replacement'] = $replacement;
        return $this;
    }

    /**
     * Get currently set replacement value
     *
     * @return string|array
     */
    public function getReplacement()
    {
        return $this->options['replacement'];
    }

    /**
     * Perform regexp replacement as filter
     *
     * @param  mixed $value
     * @return mixed
     * @throws \KORD\Filtration\Exception
     */
    public function filter($value)
    {
        if (!is_scalar($value) AND !is_array($value)) {
            return $value;
        }

        if ($this->options['pattern'] === null) {
            throw new Exception(sprintf(
                    'Filter %s does not have a valid pattern set', get_class($this)
            ));
        }

        return preg_replace($this->options['pattern'], $this->options['replacement'], $value);
    }

    /**
     * Validate a pattern and ensure it does not contain the "e" modifier
     *
     * @param  string $pattern
     * @return bool
     * @throws \KORD\Filtration\Exception
     */
    protected function validatePattern($pattern)
    {
        if (!preg_match('/(?<modifier>[imsxeADSUXJu]+)$/', $pattern, $matches)) {
            return true;
        }

        if (false !== strstr($matches['modifier'], 'e')) {
            throw new Exception(sprintf(
                    'Pattern for a PregReplace filter may not contain the "e" pattern modifier; received "%s"', $pattern
            ));
        }
    }

}
