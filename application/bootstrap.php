<?php

defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------
// Load the core KORD class
require SYSPATH . 'vendor/KORD/src/CoreSrc' . EXT;

if (is_file(APPPATH . 'vendor/KORD/Core' . EXT)) {
    // Application extends the core
    require APPPATH . 'vendor/KORD/Core' . EXT;
} else {
    // Load empty core extension
    require SYSPATH . 'vendor/KORD/application/Core' . EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('America/Chicago');

/**
 * Set the default locale.
 *
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the KORD auto-loader.
 *
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(['\KORD\Core', 'autoLoad']);

// Attach psr-4 autoloader
\KORD\Core::$autoloader = new \Psr\Psr4AutoloaderClass;
\KORD\Core::$autoloader->register();
\KORD\Core::$autoloader->addNamespace('Application', APPPATH . 'classes');
\KORD\Core::$autoloader->addNamespace('KORD', SYSPATH . 'vendor' . DS . 'KORD' . DS . 'application');
\KORD\Core::$autoloader->addNamespace('KORD', SYSPATH . 'vendor' . DS . 'KORD' . DS . 'src');

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

/**
 * Set the mb_substitute_character to "none"
 *
 * @link http://www.php.net/manual/function.mb-substitute-character.php
 */
mb_substitute_character('none');

// -- Configuration and initialization -----------------------------------------

if (isset($_SERVER['SERVER_PROTOCOL'])) {
    // Replace the default protocol.
    \KORD\HTTP::$protocol = $_SERVER['SERVER_PROTOCOL'];
}

/**
 * Set \KORD\Core::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant \KORD\Core::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KORD_ENV'])) {
    \KORD\Core::$environment = constant('\KORD\Core::' . strtoupper($_SERVER['KORD_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   null
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   true
 * - boolean  profile     enable or disable internal profiling               true
 * - boolean  caching     enable or disable internal caching                 false
 * - boolean  expose      set the X-Powered-By header                        false
 */
\KORD\Core::init([
    'base_url' => '/',
    'index_file' => false
]);

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
\KORD\Core::$log->attach(new \KORD\Log\File(APPPATH . 'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
\KORD\Core::$config->attach(new \KORD\Config\File\Reader);

/**
 * Attach a file reader to i18n. Multiple readers are supported.
 */
\KORD\Core::$i18n->attach(new \KORD\I18n\Reader\File);

/**
 * Set the default language
 */
\KORD\Core::$i18n->lang('en-us');

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
\KORD\Core::modules([
        // 'auth'       => MODPATH.'auth',       // Basic authentication
        // 'cache'      => MODPATH.'cache',      // Caching with multiple backends
         'cms'          => MODPATH.'cms',
        // 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
         'database'     => MODPATH.'database',   // Database access
        // 'image'      => MODPATH.'image',      // Image manipulation
        // 'minion'     => MODPATH.'minion',     // CLI Tasks
         'mustache'     => MODPATH.'mustache',
         'orm'          => MODPATH.'orm',        // Object Relationship Mapping
        // 'unittest'   => MODPATH.'unittest',   // Unit testing
        // 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
]);

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
\KORD\RouteRepository::set('default', '(<controller>(/<action>(/<id>)))')
        ->defaults([
            'namespace' => 'Application\Controller',
            'controller' => 'Welcome',
            'action' => 'index',
        ]);
