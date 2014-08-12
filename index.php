<?php

/**
 * The directory in which your application specific resources are located.
 * The application directory must contain the bootstrap.php file.
 */
$application = 'application';

/**
 * The directory in which your modules are located.
 */
$modules = 'modules';

/**
 * The directory in which the KORD resources are located.
 */
$system = 'system';

/**
 * The default extension of resource files. If you change this, all resources
 * must be renamed to use the new extension.
 */
define('EXT', '.php');

/**
 * The shorter name for directory separator
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * Set the PHP error reporting level. If you set this in php.ini, you remove this.
 * @link http://www.php.net/manual/errorfunc.configuration#ini.error-reporting
 *
 * When developing your application, it is highly recommended to enable notices
 * and strict warnings. Enable them by using: E_ALL | E_STRICT
 *
 * In a production environment, it is safe to ignore notices and strict warnings.
 * Disable them by using: E_ALL ^ E_NOTICE
 *
 * When using a legacy application with PHP >= 5.3, it is recommended to disable
 * deprecated notices. Disable with: E_ALL & ~E_DEPRECATED
 */
error_reporting(E_ALL | E_STRICT);

/**
 * End of standard configuration! Changing any of the code below should only be
 * attempted by those with a working knowledge of KORD internals.
 */
// Set the full path to the docroot
define('DOCROOT', realpath(__DIR__) . DS);

// Make the application relative to the docroot, for symlink'd index.php
if (!is_dir($application) AND is_dir(DOCROOT . $application)) {
    $application = DOCROOT . $application;
}

// Make the modules relative to the docroot, for symlink'd index.php
if (!is_dir($modules) AND is_dir(DOCROOT . $modules)) {
    $modules = DOCROOT . $modules;
}

// Make the system relative to the docroot, for symlink'd index.php
if (!is_dir($system) AND is_dir(DOCROOT . $system)) {
    $system = DOCROOT . $system;
}

// Define the absolute paths for configured directories
define('APPPATH', realpath($application) . DS);
define('MODPATH', realpath($modules) . DS);
define('SYSPATH', realpath($system) . DS);

// Clean up the configuration vars
unset($application, $modules, $system);

if (file_exists('install' . EXT)) {
    // Load the installation check
    return include 'install' . EXT;
}

/**
 * Define the start time of the application, used for profiling.
 */
if (!defined('KORD_START_TIME')) {
    define('KORD_START_TIME', microtime(true));
}

/**
 * Define the memory usage at the start of the application, used for profiling.
 */
if (!defined('KORD_START_MEMORY')) {
    define('KORD_START_MEMORY', memory_get_usage());
}

// Bootstrap the application
require APPPATH . 'bootstrap' . EXT;

if (PHP_SAPI == 'cli') { // Try and load minion
    class_exists('Minion_Task') OR die('Please enable the Minion module for CLI support.');
    set_exception_handler(['Minion_Exception', 'handler']);

    Minion_Task::factory(Minion_CLI::options())->execute();
} else {
    /**
     * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
     * If no source is specified, the URI will be automatically detected.
     */
    echo \KORD\Request::factory(true, [], false)
            ->execute()
            ->sendHeaders(true)
            ->body();
}
//echo new \KORD\View('profiler/stats');
