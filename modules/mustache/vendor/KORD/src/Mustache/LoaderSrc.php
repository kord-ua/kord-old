<?php

namespace KORD\Mustache;

use KORD\Core;
use KORD\Exception;

class LoaderSrc implements \Mustache_Loader, \Mustache_Loader_MutableLoader
{

    protected $base_dir = 'templates';
    protected $extension = 'mustache';
    protected $templates = [];

    public function __construct($base_dir, $options = [])
    {
        $this->base_dir = $base_dir;

        if (isset($options['extension'])) {
            $this->extension = ltrim($options['extension'], '.');
        }
    }

    public function load($name)
    {
        if (!isset($this->templates[$name])) {
            $this->templates[$name] = $this->loadFile($name);
        }

        return $this->templates[$name];
    }

    protected function loadFile($name)
    {
        $filename = Core::findFile($this->base_dir, $name = strtolower($name), $this->extension);
        
        if (!$filename AND is_file($this->base_dir . DS . $name . '.' . $this->extension)) {
            $filename = $this->base_dir . DS . $name . '.' . $this->extension;
        }

        if (!$filename) {
            throw new Exception('Mustache template "{name}" not found', ['name' => $name]);
        }

        return file_get_contents($filename);
    }

    /**
     * Set an associative array of Template sources for this loader.
     *
     * @param array $templates
     */
    public function setTemplates(array $templates)
    {
        $this->templates = array_merge($this->templates, $templates);
    }

    /**
     * Set a Template source by name.
     *
     * @param string $name
     * @param string $template Mustache Template source
     */
    public function setTemplate($name, $template)
    {
        $this->templates[$name] = $template;
    }

}
