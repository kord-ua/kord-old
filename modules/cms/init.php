<?php

defined('SYSPATH') or die('No direct script access.');

\KORD\Core::$autoloader->addNamespace('KORD', __DIR__ . DS . 'vendor' . DS . 'KORD' . DS . 'application', true);
\KORD\Core::$autoloader->addNamespace('KORD', __DIR__ . DS . 'vendor' . DS . 'KORD' . DS . 'src', true);
