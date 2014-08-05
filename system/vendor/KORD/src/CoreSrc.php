<?php

/**
 * Contains the most low-level helpers methods in KORD:
 *
 * - Environment initialization
 * - Locating files within the cascading filesystem
 * - Auto-loading and transparent extension of classes
 * - Variable and path debugging
 * 
 * @copyright  (c) 2007–2014 Kohana Team
 */

namespace KORD {

    use KORD\Config;
    use KORD\Core;
    use KORD\Debug;
    use KORD\Exception;
    use KORD\Helper\URL;
    use KORD\I18n;
    use KORD\Log;
    use KORD\Profiler;

    class CoreSrc
    {

        // Release version and codename
        const VERSION = '0.1';
        const CODENAME = 'Astrea';
        // Common environment type constants for consistency and convenience
        const PRODUCTION = 10;
        const STAGING = 20;
        const TESTING = 30;
        const DEVELOPMENT = 40;
        // Security check that is added to all generated PHP files
        const FILE_SECURITY = '<?php defined(\'SYSPATH\') OR die(\'No direct script access.\');';
        // Format of cache files: header, cache name, and data
        const FILE_CACHE = ":header \n\n// :name\n\n:data\n";

        /**
         * @var  string  Current environment name
         */
        public static $environment = Core::DEVELOPMENT;

        /**
         * @var  boolean  True if KORD is running on windows
         */
        public static $is_windows = false;

        /**
         * @var  string
         */
        public static $content_type = 'text/html';

        /**
         * @var  string  character set of input and output
         */
        public static $charset = 'utf-8';

        /**
         * @var  string  the name of the server KORD is hosted upon
         */
        public static $server_name = '';

        /**
         * @var  array   list of valid host names for this instance
         */
        public static $hostnames = [];

        /**
         * @var  string  Cache directory, used by [Core::cache]. Set by [Core::init]
         */
        public static $cache_dir;

        /**
         * @var  integer  Default lifetime for caching, in seconds, used by [Core::cache]. Set by [Core::init]
         */
        public static $cache_life = 60;

        /**
         * @var  boolean  Whether to use internal caching for [Core::findFile], does not apply to [Core::cache]. Set by [Core::init]
         */
        public static $caching = false;

        /**
         * @var  boolean  Whether to enable [profiling](KORD/profiling). Set by [Core::init]
         */
        public static $profiling = true;

        /**
         * @var  boolean  Enable KORD catching and displaying PHP errors and exceptions. Set by [Core::init]
         */
        public static $errors = true;

        /**
         * @var  array  Types of errors to display at shutdown
         */
        public static $shutdown_errors = [E_PARSE, E_ERROR, E_USER_ERROR];

        /**
         * @var  boolean  set the X-Powered-By header
         */
        public static $expose = false;

        /**
         * @var  \KORD\Log  logging object
         */
        public static $log;

        /**
         * @var  \KORD\Config  config object
         */
        public static $config;

        /**
         * @var  \Psr\Psr4AutoloaderClass  PSR-4 autoloader
         */
        public static $autoloader;

        /**
         * @var  \KORD\I18n  i18n object
         */
        public static $i18n;

        /**
         * @var  boolean  Has [Core::init] been called?
         */
        protected static $init = false;

        /**
         * @var  array   Currently active modules
         */
        protected static $modules = [];

        /**
         * @var  array   Include paths that are used to find files
         */
        protected static $paths = [APPPATH, SYSPATH];

        /**
         * @var  array   File path cache, used when caching is true in [Core::init]
         */
        protected static $files = [];

        /**
         * @var  boolean  Has the file path cache changed during this execution?  Used internally when when caching is true in [Core::init]
         */
        protected static $files_changed = false;

        /**
         * Initializes the environment:
         *
         * - Determines the current environment
         * - Set global settings
         * - Sanitizes GET, POST, and COOKIE variables
         * - Converts GET, POST, and COOKIE variables to the global character set
         *
         * The following settings can be set:
         *
         * Type      | Setting    | Description                                    | Default Value
         * ----------|------------|------------------------------------------------|---------------
         * `string`  | base_url   | The base URL for your application.  This should be the *relative* path from your DOCROOT to your `index.php` file, in other words, if KORD is in a subfolder, set this to the subfolder name, otherwise leave it as the default.  **The leading slash is required**, trailing slash is optional.   | `"/"`
         * `string`  | index_file | The name of the [front controller](http://en.wikipedia.org/wiki/Front_Controller_pattern).  This is used by KORD to generate relative urls like [HTML::anchor()] and [URL::base()]. This is usually `index.php`.  To [remove index.php from your urls](tutorials/clean-urls), set this to `false`. | `"index.php"`
         * `string`  | charset    | Character set used for all input and output    | `"utf-8"`
         * `string`  | cache_dir  | KORD's cache directory.  Used by [Core::cache] for simple internal caching, like [Fragments](kord/fragments) and **\[caching database queries](this should link somewhere)**.  This has nothing to do with the [Cache module](cache). | `APPPATH."cache"`
         * `integer` | cache_life | Lifetime, in seconds, of items cached by [Core::cache]         | `60`
         * `boolean` | errors     | Should KORD catch PHP errors and uncaught Exceptions and show the `error_view`. See [Error Handling](kord/errors) for more info. <br /> <br /> Recommended setting: `true` while developing, `false` on production servers. | `true`
         * `boolean` | profile    | Whether to enable the [Profiler](kord/profiling). <br /> <br />Recommended setting: `true` while developing, `false` on production servers. | `true`
         * `boolean` | caching    | Cache file locations to speed up [Core::findFile].  This has nothing to do with [Core::cache], [Fragments](kord/fragments) or the [Cache module](cache).  <br /> <br />  Recommended setting: `false` while developing, `true` on production servers. | `false`
         * `boolean` | expose     | Set the X-Powered-By header
         *
         * @throws  \KORD\Exception
         * @param   array   $settings   Array of settings.  See above.
         * @return  void
         * @uses    Core::sanitize
         * @uses    Core::cache
         * @uses    \KORD\Profiler
         */
        public static function init(array $settings = null)
        {
            if (Core::$init) {
                // Do not allow execution twice
                return;
            }

            // KORD is now initialized
            Core::$init = true;

            if (isset($settings['profile'])) {
                // Enable profiling
                Core::$profiling = (bool) $settings['profile'];
            }

            // Start an output buffer
            ob_start();

            if (isset($settings['errors'])) {
                // Enable error handling
                Core::$errors = (bool) $settings['errors'];
            }

            if (Core::$errors === true) {
                // Enable KORD exception handling, adds stack traces and error source.
                set_exception_handler(['\KORD\Exception', 'handler']);

                // Enable KORD error handling, converts all PHP errors to exceptions.
                set_error_handler(['\KORD\Core', 'errorHandler']);
            }

            /**
             * Enable xdebug parameter collection in development mode to improve fatal stack traces.
             */
            if (Core::$environment == Core::DEVELOPMENT AND extension_loaded('xdebug')) {
                ini_set('xdebug.collect_params', 3);
            }

            // Enable the KORD shutdown handler, which catches E_FATAL errors.
            register_shutdown_function(array('\KORD\Core', 'shutdownHandler'));

            if (isset($settings['expose'])) {
                Core::$expose = (bool) $settings['expose'];
            }

            // Determine if we are running in a Windows environment
            Core::$is_windows = (DS === '\\');

            if (isset($settings['cache_dir'])) {
                if (!is_dir($settings['cache_dir'])) {
                    try {
                        // Create the cache directory
                        mkdir($settings['cache_dir'], 0755, true);

                        // Set permissions (must be manually set to fix umask issues)
                        chmod($settings['cache_dir'], 0755);
                    } catch (\Exception $e) {
                        throw new Exception('Could not create cache directory {dir}', ['dir' => Debug::path($settings['cache_dir'])]);
                    }
                }

                // Set the cache directory path
                Core::$cache_dir = realpath($settings['cache_dir']);
            } else {
                // Use the default cache directory
                Core::$cache_dir = APPPATH . 'cache';
            }

            if (!is_writable(Core::$cache_dir)) {
                throw new Exception('Directory {dir} must be writable', ['dir' => Debug::path(Core::$cache_dir)]);
            }

            if (isset($settings['cache_life'])) {
                // Set the default cache lifetime
                Core::$cache_life = (int) $settings['cache_life'];
            }

            if (isset($settings['caching'])) {
                // Enable or disable internal caching
                Core::$caching = (bool) $settings['caching'];
            }

            if (Core::$caching === true) {
                // Load the file path cache
                Core::$files = Core::cache('\KORD\Core::findFile()');
            }

            if (isset($settings['charset'])) {
                // Set the system character set
                Core::$charset = strtolower($settings['charset']);
            }

            if (function_exists('mb_internal_encoding')) {
                // Set the MB extension encoding to the same character set
                mb_internal_encoding(Core::$charset);
            }

            if (isset($settings['base_url'])) {
                // Set the base URL
                URL::$base_url = rtrim($settings['base_url'], '/') . '/';
            }

            if (isset($settings['index_file'])) {
                // Set the index file
                URL::$index_file = trim($settings['index_file'], '/');
            }

            // Sanitize all request variables
            $_GET = Core::sanitize($_GET);
            $_POST = Core::sanitize($_POST);
            $_COOKIE = Core::sanitize($_COOKIE);

            // Load the logger if one doesn't already exist
            if (!Core::$log instanceof Log) {
                Core::$log = new Log;
            }

            // Load the config if one doesn't already exist
            if (!Core::$config instanceof Config) {
                Core::$config = new Config;
            }

            // Load the i18n if one doesn't already exist
            if (!Core::$i18n instanceof I18n) {
                Core::$i18n = new I18n;
            }
        }

        /**
         * Cleans up the environment:
         *
         * - Restore the previous error and exception handlers
         *
         * @return  void
         */
        public static function deinit()
        {
            if (Core::$init) {
                // Removed the autoloader
                spl_autoload_unregister(array('\KORD\Core', 'autoLoad'));

                if (Core::$errors) {
                    // Go back to the previous error handler
                    restore_error_handler();

                    // Go back to the previous exception handler
                    restore_exception_handler();
                }

                // Destroy objects created by init
                Core::$log = Core::$config = null;

                // Reset internal storage
                Core::$modules = Core::$files = [];
                Core::$paths = [APPPATH, SYSPATH];

                // Reset file cache status
                Core::$files_changed = false;

                // KORD is no longer initialized
                Core::$init = false;
            }
        }

        /**
         * Recursively sanitizes an input variable:
         *
         * - Strips slashes if magic quotes are enabled
         * - Normalizes all newlines to LF
         *
         * @param   mixed   $value  any variable
         * @return  mixed   sanitized variable
         */
        public static function sanitize($value)
        {
            if (is_array($value) OR is_object($value)) {
                foreach ($value as $key => $val) {
                    // Recursively clean each value
                    $value[$key] = Core::sanitize($val);
                }
            } elseif (is_string($value)) {
                if (strpos($value, "\r") !== false) {
                    // Standardize newlines
                    $value = str_replace(array("\r\n", "\r"), "\n", $value);
                }
            }

            return $value;
        }

        /**
         * Provides auto-loading support of classes that follow KORD's [class
         * naming conventions](kord/conventions#class-names-and-file-location).
         * See [Loading Classes](kord/autoloading) for more information.
         *
         *     // Loads classes/My/Class/Name.php
         *     Core::autoLoad('My\Class\Name');
         *
         * or with a custom directory:
         *
         *     // Loads vendor/My/Class/Name.php
         *     Core::autoLoad('My_Class_Name', 'vendor');
         *
         * You should never have to call this function, as simply calling a class
         * will cause it to be called.
         *
         * This function must be enabled as an autoloader in the bootstrap:
         *
         *     spl_autoload_register(['\KORD\Core', 'autoLoad']);
         *
         * @param   string  $class      Class name
         * @param   string  $directory  Directory to load from
         * @return  boolean
         */
        public static function autoLoad($class, $directory = 'vendor')
        {
            // Transform the class name according to PSR-0
            $class = ltrim($class, '\\');
            $file = '';
            $namespace = '';

            if ($last_namespace_position = strripos($class, '\\')) {
                $namespace = substr($class, 0, $last_namespace_position);
                $class = substr($class, $last_namespace_position + 1);
                $file = str_replace('\\', DS, $namespace) . DS;
            }

            $file .= str_replace('_', DS, $class);

            if ($path = Core::findFile($directory, $file)) {
                // Load the class file
                require $path;

                // Class has been found
                return true;
            }

            // Class is not in the filesystem
            return false;
        }

        /**
         * Changes the currently enabled modules. Module paths may be relative
         * or absolute, but must point to a directory:
         *
         *     Core::modules(['modules/foo', MODPATH.'bar']);
         *
         * @param   array   $modules    list of module paths
         * @return  array   enabled modules
         */
        public static function modules(array $modules = null)
        {
            if ($modules === null) {
                // Not changing modules, just return the current set
                return Core::$modules;
            }

            // Start a new list of include paths, APPPATH first
            $paths = [APPPATH];

            foreach ($modules as $name => $path) {
                if (is_dir($path)) {
                    // Add the module to include paths
                    $paths[] = $modules[$name] = realpath($path) . DS;
                } else {
                    // This module is invalid, remove it
                    throw new Exception('Attempted to load an invalid or missing module \'{module}\' at \'{path}\'', [
                'module' => $name,
                'path' => Debug::path($path),
                    ]);
                }
            }

            // Finish the include paths by adding SYSPATH
            $paths[] = SYSPATH;

            // Set the new include paths
            Core::$paths = $paths;

            // Set the current module list
            Core::$modules = $modules;

            foreach (Core::$modules as $path) {
                $init = $path . 'init' . EXT;

                if (is_file($init)) {
                    // Include the module initialization file once
                    require_once $init;
                }
            }

            return Core::$modules;
        }

        /**
         * Returns the the currently active include paths, including the
         * application, system, and each module's path.
         *
         * @return  array
         */
        public static function includePaths()
        {
            return Core::$paths;
        }

        /**
         * Searches for a file in the [Cascading Filesystem](kord/files), and
         * returns the path to the file that has the highest precedence, so that it
         * can be included.
         *
         * When searching the "config", "messages", or "i18n" directories, or when
         * the `$array` flag is set to true, an array of all the files that match
         * that path in the [Cascading Filesystem](kord/files) will be returned.
         * These files will return arrays which must be merged together.
         *
         * If no extension is given, the default extension (`EXT` set in
         * `index.php`) will be used.
         *
         *     // Returns an absolute path to views/template.php
         *     Core::findFile('views', 'template');
         *
         *     // Returns an absolute path to media/css/style.css
         *     Core::findFile('media', 'css/style', 'css');
         *
         *     // Returns an array of all the "mimes" configuration files
         *     Core::findFile('config', 'mimes');
         *
         * @param   string  $dir    directory name (views, i18n, classes, extensions, etc.)
         * @param   string  $file   filename with subdirectory
         * @param   string  $ext    extension to search for
         * @param   boolean $array  return an array of files?
         * @return  array   a list of files when $array is true
         * @return  string  single file path
         */
        public static function findFile($dir, $file, $ext = null, $array = false)
        {
            if ($ext === null) {
                // Use the default extension
                $ext = EXT;
            } elseif ($ext) {
                // Prefix the extension with a period
                $ext = ".{$ext}";
            } else {
                // Use no extension
                $ext = '';
            }

            // Create a partial path of the filename
            $path = $dir . DS . $file . $ext;

            if (Core::$caching === true AND isset(Core::$files[$path . ($array ? '_array' : '_path')])) {
                // This path has been cached
                return Core::$files[$path . ($array ? '_array' : '_path')];
            }

            if (Core::$profiling === true AND class_exists('\KORD\Profiler', false)) {
                // Start a new benchmark
                $benchmark = Profiler::start('KORD', __FUNCTION__);
            }

            if ($array OR $dir === 'config' OR $dir === 'i18n' OR $dir === 'messages') {
                // Include paths must be searched in reverse
                $paths = array_reverse(Core::$paths);

                // Array of files that have been found
                $found = [];

                foreach ($paths as $dir) {
                    if (is_file($dir . $path)) {
                        // This path has a file, add it to the list
                        $found[] = $dir . $path;
                    }
                }
            } else {
                // The file has not been found yet
                $found = false;

                foreach (Core::$paths as $dir) {
                    if (is_file($dir . $path)) {
                        // A path has been found
                        $found = $dir . $path;

                        // Stop searching
                        break;
                    }
                }
            }

            if (Core::$caching === true) {
                // Add the path to the cache
                Core::$files[$path . ($array ? '_array' : '_path')] = $found;

                // Files have been changed
                Core::$files_changed = true;
            }

            if (isset($benchmark)) {
                // Stop the benchmark
                Profiler::stop($benchmark);
            }

            return $found;
        }

        /**
         * Recursively finds all of the files in the specified directory at any
         * location in the [Cascading Filesystem](kord/files), and returns an
         * array of all the files found, sorted alphabetically.
         *
         *     // Find all view files.
         *     $views = Core::listFiles('views');
         *
         * @param   string  $directory  directory name
         * @param   array   $paths      list of paths to search
         * @return  array
         */
        public static function listFiles($directory = null, array $paths = null)
        {
            if ($directory !== null) {
                // Add the directory separator
                $directory .= DS;
            }

            if ($paths === null) {
                // Use the default paths
                $paths = Core::$paths;
            }

            // Create an array for the files
            $found = [];

            foreach ($paths as $path) {
                if (is_dir($path . $directory)) {
                    // Create a new directory iterator
                    $dir = new \DirectoryIterator($path . $directory);

                    foreach ($dir as $file) {
                        // Get the file name
                        $filename = $file->getFilename();

                        if ($filename[0] === '.' OR $filename[strlen($filename) - 1] === '~') {
                            // Skip all hidden files and UNIX backup files
                            continue;
                        }

                        // Relative filename is the array key
                        $key = $directory . $filename;

                        if ($file->isDir()) {
                            if ($sub_dir = Core::listFiles($key, $paths)) {
                                if (isset($found[$key])) {
                                    // Append the sub-directory list
                                    $found[$key] += $sub_dir;
                                } else {
                                    // Create a new sub-directory list
                                    $found[$key] = $sub_dir;
                                }
                            }
                        } else {
                            if (!isset($found[$key])) {
                                // Add new files to the list
                                $found[$key] = realpath($file->getPathName());
                            }
                        }
                    }
                }
            }

            // Sort the results alphabetically
            ksort($found);

            return $found;
        }

        /**
         * Loads a file within a totally empty scope and returns the output:
         *
         *     $foo = Core::load('foo.php');
         *
         * @param   string  $file
         * @return  mixed
         */
        public static function load($file)
        {
            return include $file;
        }

        /**
         * Provides simple file-based caching for strings and arrays:
         *
         *     // Set the "foo" cache
         *     Core::cache('foo', 'hello, world');
         *
         *     // Get the "foo" cache
         *     $foo = Core::cache('foo');
         *
         * All caches are stored as PHP code, generated with [var_export][ref-var].
         * Caching objects may not work as expected. Storing references or an
         * object or array that has recursion will cause an E_FATAL.
         *
         * The cache directory and default cache lifetime is set by [Core::init]
         *
         * [ref-var]: http://php.net/var_export
         *
         * @throws  \KORD\Exception
         * @param   string  $name       name of the cache
         * @param   mixed   $data       data to cache
         * @param   integer $lifetime   number of seconds the cache is valid for
         * @return  mixed    for getting
         * @return  boolean  for setting
         */
        public static function cache($name, $data = null, $lifetime = null)
        {
            // Cache file is a hash of the name
            $file = sha1($name) . '.txt';

            // Cache directories are split by keys to prevent filesystem overload
            $dir = Core::$cache_dir . DS . $file[0] . $file[1] . DS;

            if ($lifetime === null) {
                // Use the default lifetime
                $lifetime = Core::$cache_life;
            }

            if ($data === null) {
                if (is_file($dir . $file)) {
                    if ((time() - filemtime($dir . $file)) < $lifetime) {
                        // Return the cache
                        try {
                            return unserialize(file_get_contents($dir . $file));
                        } catch (\Exception $e) {
                            // Cache is corrupt, let return happen normally.
                        }
                    } else {
                        try {
                            // Cache has expired
                            unlink($dir . $file);
                        } catch (\Exception $e) {
                            // Cache has mostly likely already been deleted,
                            // let return happen normally.
                        }
                    }
                }

                // Cache not found
                return null;
            }

            if (!is_dir($dir)) {
                // Create the cache directory
                mkdir($dir, 0777, true);

                // Set permissions (must be manually set to fix umask issues)
                chmod($dir, 0777);
            }

            // Force the data to be a string
            $data = serialize($data);

            try {
                // Write the cache
                return (bool) file_put_contents($dir . $file, $data, LOCK_EX);
            } catch (\Exception $e) {
                // Failed to write cache
                return false;
            }
        }

        /**
         * PHP error handler, converts all errors into ErrorExceptions. This handler
         * respects error_reporting settings.
         *
         * @throws  ErrorException
         * @return  true
         */
        public static function errorHandler($code, $error, $file = null, $line = null)
        {
            if (error_reporting() & $code) {
                // This error is not suppressed by current error reporting settings
                // Convert the error into an ErrorException
                throw new \ErrorException($error, $code, 0, $file, $line);
            }

            // Do not execute the PHP error handler
            return true;
        }

        /**
         * Catches errors that are not caught by the error handler, such as E_PARSE.
         *
         * @uses    \KORD\Exception::handler
         * @return  void
         */
        public static function shutdownHandler()
        {
            if (!Core::$init) {
                // Do not execute when not active
                return;
            }

            try {
                if (Core::$caching === true AND Core::$files_changed === true) {
                    // Write the file path cache
                    Core::cache('\KORD\Core::findFile()', Core::$files);
                }
            } catch (\Exception $e) {
                // Pass the exception to the handler
                Exception::handler($e);
            }

            if (Core::$errors AND $error = error_get_last() AND in_array($error['type'], Core::$shutdown_errors)) {
                // Clean the output buffer
                ob_get_level() AND ob_clean();

                // Fake an exception for nice debugging
                Exception::handler(new \ErrorException($error['message'], $error['type'], 0, $error['file'], $error['line']));

                // Shutdown now to avoid a "death loop"
                exit(1);
            }
        }

        /**
         * Generates a version string based on the variables defined above.
         *
         * @return string
         */
        public static function version()
        {
            return 'KORD Framework ' . Core::VERSION . ' (' . Core::CODENAME . ')';
        }

    }

}

namespace {

    use KORD\Debug;

if (!function_exists('dump')) {

        /**
         * This is alias for \KORD\Debug::dump() function. The difference is
         * that this function uses echo like var_dump() instead of return
         * 
         * Returns an HTML string of information about a single variable.
         *
         * Borrows heavily on concepts from the Debug class of [Nette](http://nettephp.com/).
         *
         * @param   mixed   $value              variable to dump
         * @param   integer $length             maximum length of strings
         * @param   integer $level_recursion    recursion limit
         * @return  string
         */
        function dump($value, $length = 128, $level_recursion = 10)
        {
            echo '<pre>'.Debug::dump($value, $length, $level_recursion).'</pre>';
        }

    }
}
