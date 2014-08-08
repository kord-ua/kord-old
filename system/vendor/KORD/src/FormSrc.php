<?php

namespace KORD;

use KORD\Filtration;
use KORD\Form\Area;
use KORD\Helper\Arr;
use KORD\Validation;

class FormSrc
{

    /**
     * @var array Languages list / empty if form is single-language
     */
    protected $languages = [];

    /**
     * @var array Form areas
     */
    protected $areas = [];
    
    public function __construct()
    {
        $this->addArea(null, new Area());
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
        
        foreach ($this->getAreas() as $area) {
            $area->setLanguages($languages);
        }
        
        return $this;
    }
    
    public function getAreas()
    {
        return $this->areas;
    }

    public function addArea($name, Area $area, $sort = null)
    {
        $area->setName($name)->setLanguages($this->getLanguages());
        
        if (!is_null($sort)) {
            $this->areas = array_slice($this->areas, 0, $sort, true) +
                    [$name => $area] +
                    array_slice($this->areas, $sort, null, true);
        } else {
            $this->areas[$name] = $area;
        }
        
        return $this;
    }
    
    public function getValues()
    {
        $values = [];
        foreach ($this->getAreas() as $area) {
            foreach ($area->getElements() as $element) {
                $values[$element->getName()] = $element->getValue();
            }
        }
        return $values;
    }
    
    public function setValues($values = [])
    {
        foreach ($this->getAreas() as $area) {
            foreach ($area->getElements() as $element) {
                $element->setValue(Arr::path($values, $element->getName()));
            }
        }
        return $this;
    }
    
    public function filter()
    {
        $filtration = new Filtration();

        foreach ($this->getAreas() as $area) {
            foreach ($area->getElements() as $element) {
                if ($filters = $element->getFilters()) {
                    foreach ($filters as $filter) {
                        $filtration->addFilter($element->getName(), $filter['filter'], $filter['params'], $filter['array_values']);
                    }
                }
            }
        }

        $this->setValues($filtration->filter($this->getValues()));
    }
    
    public function validate()
    {
        $validation = new Validation($this->getValues());

        foreach ($this->getAreas() as $area) {
            foreach ($area->getElements() as $element) {
                if ($element->getLabel()) {
                    $validation->setLabel($element->getName(), $element->getLabel());
                }
                if ($rules = $element->getRules()) {
                    foreach ($rules as $rule) {
                        $validation->addRule($element->getName(), $rule['rule'], $rule['params'], $rule['array_values'], $rule['break']);
                    }
                }
            }
        }

        if ($validation->check()) {
            return true;
        } else {
            $errors = $validation->getErrors();
            $messages = [['error', 'validation.incorrect']];
            foreach ($this->getAreas() as $area) {
                foreach ($area->getElements() as $element) {
                    if ($element_errors = Arr::get($errors, $element->getName())) {
                        $element->setErrors($element_errors);
                        /*if ($element->name === 'csrf_token') {
                            $messages[] = ['error', 'validation.token_expired'];
                        }*/
                    }
                }
            }
            return $messages;
        }
    }

}
