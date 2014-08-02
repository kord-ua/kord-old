<?php

defined('SYSPATH') or die('No direct script access.');

// Load Mustache for PHP
require_once \KORD\Core::findFile('vendor', 'autoload');

\KORD\Core::$autoloader->addNamespace('KORD', __DIR__ . DS . 'vendor' . DS . 'KORD' . DS . 'application', true);
\KORD\Core::$autoloader->addNamespace('KORD', __DIR__ . DS . 'vendor' . DS . 'KORD' . DS . 'src', true);

\KORD\Mustache::$base_dir = DOCROOT . 'public' . DS . 'templates' . DS . 'default' . DS . 'views';