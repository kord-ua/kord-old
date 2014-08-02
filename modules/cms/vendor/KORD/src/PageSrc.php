<?php

/**
 * Page
 */

namespace KORD;

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
