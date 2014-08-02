<?php

namespace KORD;

use KORD\Core;
use KORD\HTML;
use KORD\Mustache;
use KORD\Mustache\Loader as MustacheLoader;
use KORD\Template;

class MustacheSrc
{
    
    /**
     * @var string  Base mustache files directory (relative or absolute)
     */
    public static $base_dir = 'templates';

    /**
     * @var \Mustache_Engine Mustache engine
     */
    protected $engine;

    public function __construct($subdir = null)
    {   
        $this->engine = new \Mustache_Engine([
            'loader' => new MustacheLoader(Mustache::$base_dir . ($subdir === null ? '' : DS . $subdir)),
            'partials_loader' => new MustacheLoader(Mustache::$base_dir . ($subdir === null ? '' : DS . $subdir) . DS . 'partials'),
            'helpers' => [
                'cssfile' => function($file) {
                    Template::instance()->addCssFile($file);
                },
                'jsfile' => function($file) {
                    Template::instance()->addJsFile($file);
                }
            ],
            'escape' => function($value) {
                return HTML::chars($value);
            },
            'cache' => Core::$cache_dir . DS . 'mustache',
        ]);
    }

    /**
     * Get Mustache engine instance
     * 
     * @return \Mustache_Engine Mustache engine
     */
    public function getEngine()
    {
        return $this->engine;
    }

}
