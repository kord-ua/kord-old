<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2014-07-11 08:17:40 --- EMERGENCY: ErrorException [ 1 ]: Class 'KORD\Filtration\Arr' not found ~ SYSPATH/vendor/KORD/src/Filtration/FilterAbstractSrc.php [ 39 ] in file:line
2014-07-11 08:17:40 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-11 08:22:05 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: Unknown type value "1" (boolean) ~ SYSPATH/vendor/KORD/src/Filtration/BooleanSrc.php [ 76 ] in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:71
2014-07-11 08:22:05 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(71): KORD\Filtration\BooleanSrc->setType(true)
#1 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(51): KORD\Filtration\FilterAbstractSrc->setOptions(Array)
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(17): KORD\Filtration\FilterAbstractSrc->__construct(Array)
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:71
2014-07-11 08:27:57 --- EMERGENCY: ErrorException [ 1 ]: Class 'Application\Controller\Boolean' not found ~ APPPATH/classes/Controller/WelcomeController.php [ 17 ] in file:line
2014-07-11 08:27:57 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-11 08:29:36 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: Unknown type value "MyClass" (string) ~ SYSPATH/vendor/KORD/src/Filtration/BooleanSrc.php [ 76 ] in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:71
2014-07-11 08:29:36 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(71): KORD\Filtration\BooleanSrc->setType('MyClass')
#1 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(51): KORD\Filtration\FilterAbstractSrc->setOptions(Array)
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(23): KORD\Filtration\FilterAbstractSrc->__construct(Array)
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:71
2014-07-11 08:29:50 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: Invalid parameter for callback: must be callable ~ SYSPATH/vendor/KORD/src/Filtration/CallbackSrc.php [ 28 ] in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:71
2014-07-11 08:29:50 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(71): KORD\Filtration\CallbackSrc->setCallback('MyClass')
#1 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(51): KORD\Filtration\FilterAbstractSrc->setOptions(Array)
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(23): KORD\Filtration\FilterAbstractSrc->__construct(Array)
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:71
2014-07-11 08:30:41 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: Invalid parameter for callback: must be callable ~ SYSPATH/vendor/KORD/src/Filtration/CallbackSrc.php [ 28 ] in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:71
2014-07-11 08:30:41 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(71): KORD\Filtration\CallbackSrc->setCallback('Application\\Con...')
#1 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(51): KORD\Filtration\FilterAbstractSrc->setOptions(Array)
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(19): KORD\Filtration\FilterAbstractSrc->__construct(Array)
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:71
2014-07-11 08:30:48 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: Invalid parameter for callback: must be callable ~ SYSPATH/vendor/KORD/src/Filtration/CallbackSrc.php [ 28 ] in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:71
2014-07-11 08:30:48 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(71): KORD\Filtration\CallbackSrc->setCallback('\\Application\\Co...')
#1 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(51): KORD\Filtration\FilterAbstractSrc->setOptions(Array)
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(19): KORD\Filtration\FilterAbstractSrc->__construct(Array)
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:71
2014-07-11 08:34:37 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: Invalid parameter for callback: must be callable ~ SYSPATH/vendor/KORD/src/Filtration/CallbackSrc.php [ 45 ] in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:73
2014-07-11 08:34:37 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(73): KORD\Filtration\CallbackSrc->setCallback('\\Application\\Co...')
#1 /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php(31): KORD\Filtration\FilterAbstractSrc->setOptions(Array)
#2 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(51): KORD\Filtration\CallbackSrc->setOptions(Array)
#3 /var/www/kord/application/classes/Controller/WelcomeController.php(19): KORD\Filtration\FilterAbstractSrc->__construct(Array)
#4 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#5 [internal function]: KORD\ControllerSrc->execute()
#6 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#7 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#8 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#9 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#10 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:73
2014-07-11 08:36:21 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: Invalid parameter for callback: must be callable ~ SYSPATH/vendor/KORD/src/Filtration/CallbackSrc.php [ 45 ] in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:73
2014-07-11 08:36:21 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(73): KORD\Filtration\CallbackSrc->setCallback('\\Application\\Co...')
#1 /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php(31): KORD\Filtration\FilterAbstractSrc->setOptions(Array)
#2 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(51): KORD\Filtration\CallbackSrc->setOptions(Array)
#3 /var/www/kord/application/classes/Controller/WelcomeController.php(19): KORD\Filtration\FilterAbstractSrc->__construct(Array)
#4 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#5 [internal function]: KORD\ControllerSrc->execute()
#6 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#7 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#8 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#9 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#10 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:73
2014-07-11 08:36:28 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: Invalid parameter for callback: must be callable ~ SYSPATH/vendor/KORD/src/Filtration/CallbackSrc.php [ 45 ] in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:73
2014-07-11 08:36:28 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(73): KORD\Filtration\CallbackSrc->setCallback('\\Application\\Co...')
#1 /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php(31): KORD\Filtration\FilterAbstractSrc->setOptions(Array)
#2 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(51): KORD\Filtration\CallbackSrc->setOptions(Array)
#3 /var/www/kord/application/classes/Controller/WelcomeController.php(19): KORD\Filtration\FilterAbstractSrc->__construct(Array)
#4 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#5 [internal function]: KORD\ControllerSrc->execute()
#6 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#7 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#8 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#9 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#10 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:73
2014-07-11 08:36:39 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: Invalid parameter for callback: must be callable ~ SYSPATH/vendor/KORD/src/Filtration/CallbackSrc.php [ 46 ] in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:73
2014-07-11 08:36:39 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(73): KORD\Filtration\CallbackSrc->setCallback('\\Application\\Co...')
#1 /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php(32): KORD\Filtration\FilterAbstractSrc->setOptions(Array)
#2 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(51): KORD\Filtration\CallbackSrc->setOptions(Array)
#3 /var/www/kord/application/classes/Controller/WelcomeController.php(19): KORD\Filtration\FilterAbstractSrc->__construct(Array)
#4 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#5 [internal function]: KORD\ControllerSrc->execute()
#6 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#7 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#8 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#9 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#10 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:73
2014-07-11 08:38:27 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: Invalid parameter for callback: must be callable ~ SYSPATH/vendor/KORD/src/Filtration/CallbackSrc.php [ 46 ] in /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php:30
2014-07-11 08:38:27 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php(30): KORD\Filtration\CallbackSrc->setCallback('\\Application\\Co...')
#1 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(51): KORD\Filtration\CallbackSrc->setOptions(Array)
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(19): KORD\Filtration\FilterAbstractSrc->__construct(Array)
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php:30
2014-07-11 08:38:42 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: Invalid parameter for callback: must be callable ~ SYSPATH/vendor/KORD/src/Filtration/CallbackSrc.php [ 45 ] in /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php:29
2014-07-11 08:38:42 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php(29): KORD\Filtration\CallbackSrc->setCallback('\\Application\\Co...')
#1 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(51): KORD\Filtration\CallbackSrc->setOptions(Array)
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(19): KORD\Filtration\FilterAbstractSrc->__construct(Array)
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php:29
2014-07-11 08:38:54 --- EMERGENCY: ErrorException [ 2048 ]: call_user_func_array() expects parameter 1 to be a valid callback, non-static method Application\Controller\WelcomeController::reverse() should not be called statically ~ SYSPATH/vendor/KORD/src/Filtration/CallbackSrc.php [ 97 ] in file:line
2014-07-11 08:38:54 --- DEBUG: #0 [internal function]: KORD\CoreSrc::errorHandler(2048, 'call_user_func_...', '/var/www/kord/s...', 97, Array)
#1 /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php(97): call_user_func_array(Array, Array)
#2 /var/www/kord/system/vendor/KORD/src/FiltrationSrc.php(183): KORD\Filtration\CallbackSrc->filter('0')
#3 /var/www/kord/application/classes/Controller/WelcomeController.php(21): KORD\FiltrationSrc->filter(Array)
#4 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#5 [internal function]: KORD\ControllerSrc->execute()
#6 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#7 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#8 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#9 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#10 {main} in file:line