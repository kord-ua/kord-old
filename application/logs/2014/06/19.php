<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2014-06-19 05:24:52 --- EMERGENCY: ErrorException [ 1 ]: Class 'KORD\Mustache' not found ~ APPPATH/classes/Controller/WelcomeController.php [ 13 ] in file:line
2014-06-19 05:24:52 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-19 05:25:25 --- EMERGENCY: ErrorException [ 1 ]: Class 'Kohana' not found ~ MODPATH/mustache/init.php [ 6 ] in file:line
2014-06-19 05:25:25 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-19 05:25:47 --- EMERGENCY: ErrorException [ 1 ]: Class 'KORD\Mustache_Engine' not found ~ MODPATH/mustache/vendor/KORD/src/MustacheSrc.php [ 14 ] in file:line
2014-06-19 05:25:47 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-19 05:26:32 --- EMERGENCY: ErrorException [ 1 ]: Interface 'KORD\Mustache\Mustache_Loader' not found ~ MODPATH/mustache/vendor/KORD/src/Mustache/LoaderSrc.php [ 8 ] in file:line
2014-06-19 05:26:32 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-19 05:26:45 --- EMERGENCY: ErrorException [ 4096 ]: Object of class KORD\Mustache could not be converted to string ~ SYSPATH/vendor/KORD/src/ResponseSrc.php [ 150 ] in /var/www/kord/system/vendor/KORD/src/ResponseSrc.php:150
2014-06-19 05:26:45 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/ResponseSrc.php(150): KORD\CoreSrc::errorHandler(4096, 'Object of class...', '/var/www/kord/s...', 150, Array)
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(13): KORD\ResponseSrc->body(Object(KORD\Mustache))
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/ResponseSrc.php:150
2014-06-19 05:30:13 --- EMERGENCY: ErrorException [ 1 ]: Cannot access protected property KORD\Mustache::$engine ~ APPPATH/classes/Controller/WelcomeController.php [ 13 ] in file:line
2014-06-19 05:30:13 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-19 05:31:49 --- EMERGENCY: ErrorException [ 1 ]: Cannot access protected property KORD\Mustache::$engine ~ APPPATH/classes/Controller/WelcomeController.php [ 13 ] in file:line
2014-06-19 05:31:49 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-19 05:32:12 --- EMERGENCY: ErrorException [ 4096 ]: Object of class __Mustache_1ad932c6c321676ba220226c5adb94d4 could not be converted to string ~ SYSPATH/vendor/KORD/src/ResponseSrc.php [ 150 ] in /var/www/kord/system/vendor/KORD/src/ResponseSrc.php:150
2014-06-19 05:32:12 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/ResponseSrc.php(150): KORD\CoreSrc::errorHandler(4096, 'Object of class...', '/var/www/kord/s...', 150, Array)
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(13): KORD\ResponseSrc->body(Object(__Mustache_1ad932c6c321676ba220226c5adb94d4))
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/ResponseSrc.php:150
2014-06-19 07:40:41 --- EMERGENCY: KORD\Exception [ 0 ]: Mustache template "test" not found ~ MODPATH/mustache/vendor/KORD/src/Mustache/LoaderSrc.php [ 42 ] in /var/www/kord/modules/mustache/vendor/KORD/src/Mustache/LoaderSrc.php:27
2014-06-19 07:40:41 --- DEBUG: #0 /var/www/kord/modules/mustache/vendor/KORD/src/Mustache/LoaderSrc.php(27): KORD\Mustache\LoaderSrc->loadFile('test')
#1 /var/www/kord/modules/mustache/vendor/mustache/mustache/src/Mustache/Engine.php(585): KORD\Mustache\LoaderSrc->load('test')
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(16): Mustache_Engine->loadTemplate('test')
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/mustache/vendor/KORD/src/Mustache/LoaderSrc.php:27
2014-06-19 07:41:14 --- EMERGENCY: KORD\Exception [ 0 ]: Mustache template "test" not found ~ MODPATH/mustache/vendor/KORD/src/Mustache/LoaderSrc.php [ 42 ] in /var/www/kord/modules/mustache/vendor/KORD/src/Mustache/LoaderSrc.php:27
2014-06-19 07:41:14 --- DEBUG: #0 /var/www/kord/modules/mustache/vendor/KORD/src/Mustache/LoaderSrc.php(27): KORD\Mustache\LoaderSrc->loadFile('test')
#1 /var/www/kord/modules/mustache/vendor/mustache/mustache/src/Mustache/Engine.php(585): KORD\Mustache\LoaderSrc->load('test')
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(16): Mustache_Engine->loadTemplate('test')
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/mustache/vendor/KORD/src/Mustache/LoaderSrc.php:27
2014-06-19 11:03:36 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Template::addJsFile() ~ MODPATH/mustache/vendor/KORD/src/MustacheSrc.php [ 30 ] in file:line
2014-06-19 11:03:36 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-19 13:14:57 --- EMERGENCY: ErrorException [ 4096 ]: Argument 1 passed to KORD\Controller::__construct() must be an instance of Request, instance of KORD\Request given ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 24 ] in /var/www/kord/modules/cms/vendor/KORD/application/Controller.php:24
2014-06-19 13:14:57 --- DEBUG: #0 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(24): KORD\CoreSrc::errorHandler(4096, 'Argument 1 pass...', '/var/www/kord/m...', 24, Array)
#1 [internal function]: KORD\Controller->__construct(Object(KORD\Request), Object(KORD\Response))
#2 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(88): ReflectionClass->newInstance(Object(KORD\Request), Object(KORD\Response))
#3 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#4 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#5 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#6 {main} in /var/www/kord/modules/cms/vendor/KORD/application/Controller.php:24
2014-06-19 13:19:33 --- EMERGENCY: ErrorException [ 4096 ]: Argument 1 passed to KORD\Controller::__construct() must be an instance of Request, instance of KORD\Request given ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 24 ] in /var/www/kord/modules/cms/vendor/KORD/application/Controller.php:24
2014-06-19 13:19:33 --- DEBUG: #0 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(24): KORD\CoreSrc::errorHandler(4096, 'Argument 1 pass...', '/var/www/kord/m...', 24, Array)
#1 [internal function]: KORD\Controller->__construct(Object(KORD\Request), Object(KORD\Response))
#2 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(88): ReflectionClass->newInstance(Object(KORD\Request), Object(KORD\Response))
#3 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#4 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#5 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#6 {main} in /var/www/kord/modules/cms/vendor/KORD/application/Controller.php:24