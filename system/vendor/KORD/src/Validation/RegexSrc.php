<?php

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace KORD\Validation;

use KORD\Validation\Exception;

class RegexSrc extends RuleAbstract
{

    /**
     * Default options to set for the validator
     *
     * @var mixed
     */
    protected $options = [
        'patterns' => []
    ];

    /**
     * Returns the patterns option
     *
     * @return string
     */
    public function getPatterns()
    {
        return $this->options['patterns'];
    }

    /**
     * Sets the patterns option
     *
     * @param  string|array $patterns
     * @throws \KORD\Validation\Exception if there is a fatal error in pattern matching
     * @return $this Provides a fluent interface
     */
    public function setPatterns($patterns)
    {
        if (!is_array($patterns)) {
            $patterns = [$patterns];
        }

        $this->options['patterns'] = [];

        foreach ($patterns as $pattern) {
            $status = @preg_match((string) $pattern, "Test");

            if (false === $status) {
                throw new Exception("Internal error parsing the pattern '{$pattern}'");
            }

            $this->options['patterns'][] = (string) $pattern;
        }

        return $this;
    }

    /**
     * Returns true if and only if $value matches against the pattern option
     *
     * @param  string $value
     * @return bool
     */
    public function isValid($value)
    {
        if (!is_string($value) AND ! is_int($value) AND ! is_float($value)) {
            $this->addError('regexInvalid');
            return false;
        }

        $is_valid = false;
        foreach ($this->getPatterns() as $pattern) {
            $status = @preg_match($pattern, $value);

            if (false === $status) {
                $this->addError('regexErrorous', [':pattern' => $pattern]);
                return false;
            }
            
            if ($status) {
                $is_valid = true;
            }
        }
        
        if (!$is_valid) {
            $this->addError('regexNotMatch');
            return false;
        }

        return true;
    }

}
