<?php

namespace KORD\Form;

class ButtonSrc extends Element
{
    
    protected $view = 'button';
    
    protected $title = 'Submit';

    protected $type = 'submit';

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        if (!is_string($title) OR empty($title)) {
            throw new Exception("Button title should be a non-empty string");
        }

        $this->title = $title;

        return $this;
    }
    
    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        if (!is_string($type) OR empty($type)) {
            throw new Exception("Button type should be a non-empty string");
        }

        $this->type = $type;

        return $this;
    }

}
