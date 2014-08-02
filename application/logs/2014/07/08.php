<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2014-07-08 03:53:34 --- EMERGENCY: ErrorException [ 1 ]: Class 'KORD\Filtration\Core' not found ~ SYSPATH/vendor/KORD/src/Filtration/AlphaSrc.php [ 51 ] in file:line
2014-07-08 03:53:34 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-08 06:32:35 --- EMERGENCY: ErrorException [ 1 ]: Undefined class constant 'self::NULL' ~ APPPATH/classes/Controller/WelcomeController.php [ 16 ] in file:line
2014-07-08 06:32:35 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-08 06:42:11 --- EMERGENCY: ErrorException [ 2 ]: Missing argument 1 for KORD\Filtration\CallbackSrc::__construct(), called in /var/www/kord/application/classes/Controller/WelcomeController.php on line 16 and defined ~ SYSPATH/vendor/KORD/src/Filtration/CallbackSrc.php [ 30 ] in /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php:30
2014-07-08 06:42:11 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php(30): KORD\CoreSrc::errorHandler(2, 'Missing argumen...', '/var/www/kord/s...', 30, Array)
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(16): KORD\Filtration\CallbackSrc->__construct()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php:30
2014-07-08 06:42:37 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: Callback can not be accessed ~ SYSPATH/vendor/KORD/src/Filtration/CallbackSrc.php [ 71 ] in /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php:46
2014-07-08 06:42:37 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php(46): KORD\Filtration\CallbackSrc->setCallback(NULL)
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(16): KORD\Filtration\CallbackSrc->__construct()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php:46
2014-07-08 06:44:42 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: Missing callback to use ~ SYSPATH/vendor/KORD/src/Filtration/CallbackSrc.php [ 43 ] in /var/www/kord/application/classes/Controller/WelcomeController.php:16
2014-07-08 06:44:42 --- DEBUG: #0 /var/www/kord/application/classes/Controller/WelcomeController.php(16): KORD\Filtration\CallbackSrc->__construct()
#1 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#2 [internal function]: KORD\ControllerSrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#4 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#5 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#6 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#7 {main} in /var/www/kord/application/classes/Controller/WelcomeController.php:16
2014-07-08 06:45:16 --- EMERGENCY: ErrorException [ 2 ]: Missing argument 2 for KORD\ArrSrc::get() ~ SYSPATH/vendor/KORD/src/ArrSrc.php [ 248 ] in /var/www/kord/system/vendor/KORD/src/ArrSrc.php:248
2014-07-08 06:45:16 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/ArrSrc.php(248): KORD\CoreSrc::errorHandler(2, 'Missing argumen...', '/var/www/kord/s...', 248, Array)
#1 [internal function]: KORD\ArrSrc::get('0')
#2 /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php(121): call_user_func_array(Array, Array)
#3 /var/www/kord/system/vendor/KORD/src/FiltrationSrc.php(182): KORD\Filtration\CallbackSrc->filter('0')
#4 /var/www/kord/application/classes/Controller/WelcomeController.php(18): KORD\FiltrationSrc->filter(Array)
#5 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#6 [internal function]: KORD\ControllerSrc->execute()
#7 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#8 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#9 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#10 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#11 {main} in /var/www/kord/system/vendor/KORD/src/ArrSrc.php:248
2014-07-08 07:44:51 --- EMERGENCY: ErrorException [ 4 ]: syntax error, unexpected '->' (T_OBJECT_OPERATOR) ~ APPPATH/classes/Controller/WelcomeController.php [ 16 ] in file:line
2014-07-08 07:44:51 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-08 07:46:11 --- EMERGENCY: ErrorException [ 4 ]: syntax error, unexpected '->' (T_OBJECT_OPERATOR) ~ APPPATH/classes/Controller/WelcomeController.php [ 15 ] in file:line
2014-07-08 07:46:11 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-08 07:48:58 --- EMERGENCY: ErrorException [ 2 ]: preg_replace(): Delimiter must not be alphanumeric or backslash ~ SYSPATH/vendor/KORD/src/Filtration/PregReplaceSrc.php [ 111 ] in file:line
2014-07-08 07:48:58 --- DEBUG: #0 [internal function]: KORD\CoreSrc::errorHandler(2, 'preg_replace():...', '/var/www/kord/s...', 111, Array)
#1 /var/www/kord/system/vendor/KORD/src/Filtration/PregReplaceSrc.php(111): preg_replace(Array, Array, 'Hy bob!')
#2 /var/www/kord/system/vendor/KORD/src/FiltrationSrc.php(183): KORD\Filtration\PregReplaceSrc->filter('Hy bob!')
#3 /var/www/kord/application/classes/Controller/WelcomeController.php(18): KORD\FiltrationSrc->filter(Array)
#4 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#5 [internal function]: KORD\ControllerSrc->execute()
#6 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#7 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#8 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#9 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#10 {main} in file:line
2014-07-08 07:53:30 --- EMERGENCY: ErrorException [ 1 ]: Class 'KORD\Filtration\RealPath' not found ~ APPPATH/classes/Controller/WelcomeController.php [ 16 ] in file:line
2014-07-08 07:53:30 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line