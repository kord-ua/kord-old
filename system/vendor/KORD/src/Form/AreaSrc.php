<?php

namespace KORD\Form;

use KORD\Exception;
use KORD\Form\Element;
use KORD\Helper\Arr;

/**
 * @copyright  (c) 2014 Andriy Strepetov
 */
class AreaSrc
{
    
    /**
     *
     * @var array Languages list / empty if form is single-language
     */
    protected $languages = [];

    /**
     *
     * @var string Area label 
     */
    protected $label;

    /**
     *
     * @var string Area name
     */
    protected $name;
    
    /**
     *
     * @var array Area elements
     */
    protected $elements = [];
    
    public function __construct($name)
    {
        $this->setName($name);
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
        
        foreach ($this->getElements() as $element) {
            $element->setLanguages($languages);
        }
        
        return $this;
    }
    
    public function getLabel()
    {
        return $this->label;
    }
    
    public function setLabel($label = '')
    {
        if (!is_string($label)) {
            throw new Exception("Area label should be string");
        }
        
        $this->label = $label;
        
        return $this;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name = null)
    {
        if ((!is_string($name) OR empty($name)) AND !is_null($name)) {
            throw new Exception("Area name should be null or non-empty string");
        }
        
        $this->name = $name;
        
        return $this;
    }
    
    public function getElements()
    {
        return $this->elements;
    }
    
    public function addElement(Element $element, $sort = null)
    {
        $element->setLanguages($this->getLanguages());
        
        if (!is_null($sort)) {
            $this->elements = array_slice($this->elements, 0, $sort, true) +
                    [$element->getName() => $element] +
                    array_slice($this->elements, $sort, null, true);
        } else {
            $this->elements[$element->getName()] = $element;
        }
        
        return $this;
    }

}
