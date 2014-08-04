<?php

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace KORD\Validation;

class AlphaSrc extends RuleAbstract
{

    /**
     * Options for this validator
     *
     * @var array
     */
    protected $options = [
        'allow_white_space' => false, // Whether to allow white space characters; off by default
        'lang' => null
    ];

    /**
     * Returns the allow_white_space option
     *
     * @return bool
     */
    public function getAllowWhiteSpace()
    {
        return $this->options['allow_white_space'];
    }

    /**
     * Sets the allowWhiteSpace option
     *
     * @param  bool $allow_white_space
     * @return $this Provides a fluent interface
     */
    public function setAllowWhiteSpace($allow_white_space)
    {
        $this->options['allow_white_space'] = (bool) $allow_white_space;
        return $this;
    }
    
    /**
     * Sets the lang option
     *
     * @param  string|null $lang
     * @return $this
     */
    public function setLang($lang)
    {
        $this->options['lang'] = $lang;
        return $this;
    }

    /**
     * Returns the lang option
     *
     * @return string
     */
    public function getLang()
    {
        return $this->options['lang'];
    }

    /**
     * Returns true if and only if $value contains only alphabetic characters
     *
     * @param  string $value
     * @return bool
     */
    public function isValid($value)
    {   
        if (!is_string($value)) {
            $this->addError('alphaInvalid');
            return false;
        }

        $filter = (new \KORD\Filtration\Alpha())->setOptions($this->options);

        if ($value != $filter->filter($value)) {
            $this->addError('notAlpha');
            return false;
        }

        return true;
    }

}
