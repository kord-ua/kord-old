<?php

namespace KORD;

use KORD\Helper\HTML;
use KORD\Template;

/**
 * Template singleton
 */
class TemplateSrc
{

    /**
     * @var \KORD\Template  Template instance 
     */
    protected static $instance;

    /**
     * Get KORD\Template singleton instance
     * 
     * @return \KORD\Template
     */
    public static function instance()
    {
        if (empty(Template::$instance)) {
            Template::$instance = new Template();
        }
        return Template::$instance;
    }

    protected function __construct()
    {
        
    }

    protected function __clone()
    {
        
    }

    protected function __wakeup()
    {
        
    }

    /**
     * @var array  list of included styles
     */
    protected $css = [];

    /**
     * @var array  list of included scripts
     */
    protected $js = [];

    /**
     * Adds css file to a collection
     * 
     * @param string $file  CSS file name
     */
    public function addCssFile($file)
    {
        $this->css[] = HTML::style($file);
    }

    /**
     * Adds css code to a collection
     * 
     * @param string $code  CSS code
     */
    public function addCssCode($code)
    {
        $this->css[] = '<style type="text/css">' . $code . '</style>';
    }

    /**
     * Adds js file to a collection
     * 
     * @param string $file  JS file name
     */
    public function addJsFile($file)
    {
        $this->js[] = HTML::script($file);
    }

    /**
     * Adds js code to a collection
     * 
     * @param string $code  JS code
     */
    public function addJsCode($code)
    {
        $this->js[] = '<script type="text/javascript">' . $code . '</script>';
    }
    
    public function getCss()
    {
        return $this->css;
    }
    
    public function getJs()
    {
        return $this->js;
    }

}
