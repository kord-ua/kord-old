<?php

defined('SYSPATH') or die('No direct script access.');

// Load HTMLPurifier
require_once \KORD\Core::findFile('vendor' . DS . 'htmlpurifier' . DS . 'library', 'HTMLPurifier.auto');
// Init default instance
\KORD\HTMLPurifier::setInstance(null, []);
