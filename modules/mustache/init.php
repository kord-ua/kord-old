<?php

defined('SYSPATH') or die('No direct script access.');

// Load Mustache for PHP
require_once \KORD\Core::findFile('vendor', 'autoload');

\KORD\Mustache::$base_dir = DOCROOT . 'public' . DS . 'templates' . DS . 'default' . DS . 'views';