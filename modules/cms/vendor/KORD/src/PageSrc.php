<?php

namespace KORD;

/**
 * Page
 * 
 * @copyright  (c) 2014 Andriy Strepetov
 */
class PageSrc
{
    
    public $title;
    
    public function css()
    {
        return Template::instance()->getCss();
    }
    
    public function js()
    {
        return Template::instance()->getJs();
    }

}
