<?php

namespace KORD\Form;

use KORD\Exception;
use KORD\Helper\Arr;
use KORD\View;

/**
 * @copyright  (c) 2014 Andriy Strepetov
 */
abstract class ElementSrc
{

    /**
     *
     * @var array Languages list / empty if form is single-language
     */
    protected $languages = [];

    /**
     *
     * @var bool Is element multi-lingual?
     */
    protected $multilingual = false;

    /**
     *
     * @var string Element label 
     */
    protected $label;

    /**
     *
     * @var string Element name
     */
    protected $name;

    /**
     *
     * @var mixed Element value
     */
    protected $value;

    /**
     *
     * @var array Filtration filters
     */
    protected $filters = [];

    /**
     *
     * @var array Validation rules
     */
    protected $rules = [];

    /**
     *
     * @var array Element rules errors
     */
    public $errors = [];

    /**
     *
     * @var string Element view
     */
    protected $view;

    public function __construct($name)
    {
        $this->setName($name);
    }

    public function isMultilingual()
    {
        return $this->multilingual;
    }

    public function setMultilingual($flag)
    {
        $this->multilingual = (bool) $flag;

        return $this;
    }

    public function getLanguages()
    {
        return $this->languages;
    }

    public function setLanguages($languages)
    {
        if (!is_array($languages) OR Arr::isAssoc($languages)) {
            throw new Exception("Languages list should be a non-associative array");
        }

        $this->languages = $languages;

        return $this;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label = '')
    {
        if (!is_string($label)) {
            throw new Exception("Element label should be string");
        }

        $this->label = $label;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if (!is_string($name) OR empty($name)) {
            throw new Exception("Element name should be non-empty string");
        }

        $this->name = $name;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function prependFilter($filter, $params = null, $array_values = false)
    {
        $filter = [
            'filter' => $filter,
            'params' => $params,
            'array_values' => $array_values
        ];

        array_unshift($this->filters, $filter);

        return $this;
    }

    public function addFilter($filter, $params = null, $array_values = false)
    {
        $this->filters[] = [
            'filter' => $filter,
            'params' => $params,
            'array_values' => $array_values
        ];

        return $this;
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function prependRule($rule, $params = null, $array_values = false, $break = null)
    {
        $rule = [
            'rule' => $rule,
            'params' => $params,
            'array_values' => $array_values,
            'break' => $break
        ];

        array_unshift($this->rules, $rule);

        return $this;
    }

    public function addRule($rule, $params = null, $array_values = false, $break = null)
    {
        $this->rules[] = [
            'rule' => $rule,
            'params' => $params,
            'array_values' => $array_values,
            'break' => $break
        ];

        return $this;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setErrors($errors)
    {
        if (!is_array($errors)) {
            throw new Exception("Element rule errors should be array");
        }

        $this->errors = $errors;

        return $this;
    }

    public function getView()
    {
        return $this->view;
    }

    public function setView($view)
    {
        if (!is_string($view) OR empty($view)) {
            throw new Exception("Element view should be non-empty string");
        }

        $this->view = $view;

        return $this;
    }

    public function render()
    {
        return (new View('form/' . $this->getView()))
                        ->set('element', $this)
                        ->render();
    }

}
