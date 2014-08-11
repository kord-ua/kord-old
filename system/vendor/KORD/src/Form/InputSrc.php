<?php

namespace KORD\Form;

/**
 * @copyright  (c) 2014 Andriy Strepetov
 */
class InputSrc extends Element
{
    
    protected $view = 'input';

    protected $type = 'text';

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        if (!is_string($type) OR empty($type)) {
            throw new Exception("Input type should be a non-empty string");
        }

        $this->type = $type;

        return $this;
    }

}
