<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2014-07-12 04:52:03 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined function Application\Controller\dump() ~ APPPATH/classes/Controller/WelcomeController.php [ 19 ] in file:line
2014-07-12 04:52:03 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-12 04:52:21 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined function dump() ~ APPPATH/classes/Controller/WelcomeController.php [ 19 ] in file:line
2014-07-12 04:52:21 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-12 04:56:04 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined function dump() ~ APPPATH/classes/Controller/WelcomeController.php [ 20 ] in file:line
2014-07-12 04:56:04 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-12 04:56:05 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined function dump() ~ APPPATH/classes/Controller/WelcomeController.php [ 20 ] in file:line
2014-07-12 04:56:05 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-12 04:59:52 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined function Application\Controller\dsump() ~ APPPATH/classes/Controller/WelcomeController.php [ 19 ] in file:line
2014-07-12 04:59:52 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-12 05:00:01 --- EMERGENCY: ErrorException [ 1 ]: Class 'KORD\Filtration\HtmEntities' not found ~ APPPATH/classes/Controller/WelcomeController.php [ 17 ] in file:line
2014-07-12 05:00:01 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-12 05:00:31 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: tet ~ APPPATH/classes/Controller/WelcomeController.php [ 19 ] in /var/www/kord/application/classes/Controller/WelcomeController.php:19
2014-07-12 05:00:31 --- DEBUG: #0 /var/www/kord/application/classes/Controller/WelcomeController.php(19): KORD\CoreSrc::errorHandler(8, 'Undefined varia...', '/var/www/kord/a...', 19, Array)
#1 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#2 [internal function]: KORD\ControllerSrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#4 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#5 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#6 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#7 {main} in /var/www/kord/application/classes/Controller/WelcomeController.php:19
2014-07-12 05:05:08 --- EMERGENCY: ErrorException [ 1 ]: Undefined class constant 'BOOLEAN' ~ APPPATH/classes/Controller/WelcomeController.php [ 17 ] in file:line
2014-07-12 05:05:08 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-12 05:08:31 --- EMERGENCY: ErrorException [ 2 ]: preg_replace(): Delimiter must not be alphanumeric or backslash ~ SYSPATH/vendor/KORD/src/Filtration/PregReplaceSrc.php [ 103 ] in file:line
2014-07-12 05:08:31 --- DEBUG: #0 [internal function]: KORD\CoreSrc::errorHandler(2, 'preg_replace():...', '/var/www/kord/s...', 103, Array)
#1 /var/www/kord/system/vendor/KORD/src/Filtration/PregReplaceSrc.php(103): preg_replace('bob', 'Hi', 'Hi bob!')
#2 /var/www/kord/system/vendor/KORD/src/FiltrationSrc.php(183): KORD\Filtration\PregReplaceSrc->filter('Hi bob!')
#3 /var/www/kord/application/classes/Controller/WelcomeController.php(19): KORD\FiltrationSrc->filter(Array)
#4 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#5 [internal function]: KORD\ControllerSrc->execute()
#6 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#7 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#8 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#9 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#10 {main} in file:line
2014-07-12 05:16:10 --- EMERGENCY: ErrorException [ 2048 ]: call_user_func_array() expects parameter 1 to be a valid callback, non-static method Application\Controller\MyClass::reverse() should not be called statically ~ SYSPATH/vendor/KORD/src/Filtration/CallbackSrc.php [ 97 ] in file:line
2014-07-12 05:16:10 --- DEBUG: #0 [internal function]: KORD\CoreSrc::errorHandler(2048, 'call_user_func_...', '/var/www/kord/s...', 97, Array)
#1 /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php(97): call_user_func_array(Array, Array)
#2 /var/www/kord/system/vendor/KORD/src/FiltrationSrc.php(183): KORD\Filtration\CallbackSrc->filter('Hi bob!')
#3 /var/www/kord/application/classes/Controller/WelcomeController.php(25): KORD\FiltrationSrc->filter(Array)
#4 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#5 [internal function]: KORD\ControllerSrc->execute()
#6 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#7 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#8 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#9 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#10 {main} in file:line
2014-07-12 05:16:59 --- EMERGENCY: ErrorException [ 2048 ]: call_user_func_array() expects parameter 1 to be a valid callback, non-static method Application\Controller\MyClass::reverse() should not be called statically ~ SYSPATH/vendor/KORD/src/Filtration/CallbackSrc.php [ 97 ] in file:line
2014-07-12 05:16:59 --- DEBUG: #0 [internal function]: KORD\CoreSrc::errorHandler(2048, 'call_user_func_...', '/var/www/kord/s...', 97, Array)
#1 /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php(97): call_user_func_array(Array, Array)
#2 /var/www/kord/system/vendor/KORD/src/FiltrationSrc.php(183): KORD\Filtration\CallbackSrc->filter('Hi bob!')
#3 /var/www/kord/application/classes/Controller/WelcomeController.php(25): KORD\FiltrationSrc->filter(Array)
#4 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#5 [internal function]: KORD\ControllerSrc->execute()
#6 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#7 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#8 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#9 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#10 {main} in file:line
2014-07-12 05:17:25 --- EMERGENCY: ErrorException [ 2048 ]: call_user_func_array() expects parameter 1 to be a valid callback, non-static method Application\Controller\MyClass::reverse() should not be called statically ~ SYSPATH/vendor/KORD/src/Filtration/CallbackSrc.php [ 97 ] in file:line
2014-07-12 05:17:25 --- DEBUG: #0 [internal function]: KORD\CoreSrc::errorHandler(2048, 'call_user_func_...', '/var/www/kord/s...', 97, Array)
#1 /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php(97): call_user_func_array(Array, Array)
#2 /var/www/kord/system/vendor/KORD/src/FiltrationSrc.php(183): KORD\Filtration\CallbackSrc->filter('Hi bob!')
#3 /var/www/kord/application/classes/Controller/WelcomeController.php(25): KORD\FiltrationSrc->filter(Array)
#4 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#5 [internal function]: KORD\ControllerSrc->execute()
#6 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#7 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#8 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#9 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#10 {main} in file:line