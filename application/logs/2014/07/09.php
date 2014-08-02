<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2014-07-09 11:18:49 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: The given encoding 'ANSI' is not supported by mbstring ~ SYSPATH/vendor/KORD/src/Filtration/StringToUpperSrc.php [ 68 ] in /var/www/kord/system/vendor/KORD/src/Filtration/StringToUpperSrc.php:38
2014-07-09 11:18:49 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/StringToUpperSrc.php(38): KORD\Filtration\StringToUpperSrc->setEncoding('ANSI')
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(16): KORD\Filtration\StringToUpperSrc->__construct('ANSI')
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/StringToUpperSrc.php:38
2014-07-09 11:19:21 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: The given encoding 'ANSI' is not supported by mbstring ~ SYSPATH/vendor/KORD/src/Filtration/StringToUpperSrc.php [ 68 ] in /var/www/kord/system/vendor/KORD/src/Filtration/StringToUpperSrc.php:38
2014-07-09 11:19:21 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/StringToUpperSrc.php(38): KORD\Filtration\StringToUpperSrc->setEncoding('ANSI')
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(17): KORD\Filtration\StringToUpperSrc->__construct('ANSI')
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/StringToUpperSrc.php:38
2014-07-09 14:59:29 --- EMERGENCY: ErrorException [ 8 ]: Undefined index: lang ~ SYSPATH/vendor/KORD/src/Filtration/AlnumSrc.php [ 76 ] in /var/www/kord/system/vendor/KORD/src/Filtration/AlnumSrc.php:76
2014-07-09 14:59:29 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/AlnumSrc.php(76): KORD\CoreSrc::errorHandler(8, 'Undefined index...', '/var/www/kord/s...', 76, Array)
#1 /var/www/kord/system/vendor/KORD/src/FiltrationSrc.php(183): KORD\Filtration\AlnumSrc->filter('This is (my) co...')
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(18): KORD\FiltrationSrc->filter(Array)
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/AlnumSrc.php:76
2014-07-09 15:55:06 --- EMERGENCY: ErrorException [ 1 ]: Class 'KORD\Filtration\Locale' not found ~ SYSPATH/vendor/KORD/src/Filtration/AlnumSrc.php [ 103 ] in file:line
2014-07-09 15:55:06 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-09 17:22:03 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Filtration\Boolean::setOptions() ~ SYSPATH/vendor/KORD/src/Filtration/BooleanSrc.php [ 69 ] in file:line
2014-07-09 17:22:03 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-09 17:48:37 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Filtration\Boolean::setOptions() ~ SYSPATH/vendor/KORD/src/Filtration/BooleanSrc.php [ 69 ] in file:line
2014-07-09 17:48:37 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-09 17:59:19 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: The option "0" does not have a matching set0 setter method or options[0] array key ~ SYSPATH/vendor/KORD/src/Filtration/FilterAbstractSrc.php [ 37 ] in /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php:28
2014-07-09 17:59:19 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php(28): KORD\Filtration\FilterAbstractSrc->setOptions(Array)
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(16): KORD\Filtration\CallbackSrc->__construct(Array)
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php:28
2014-07-09 17:59:52 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: The option "0" does not have a matching set0 setter method or options[0] array key ~ SYSPATH/vendor/KORD/src/Filtration/FilterAbstractSrc.php [ 37 ] in /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php:28
2014-07-09 17:59:52 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php(28): KORD\Filtration\FilterAbstractSrc->setOptions(Array)
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(16): KORD\Filtration\CallbackSrc->__construct(Array)
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php:28
2014-07-09 18:01:44 --- EMERGENCY: ErrorException [ 2048 ]: call_user_func_array() expects parameter 1 to be a valid callback, non-static method KORD\Filtration\MyClass::Reverse() should not be called statically ~ SYSPATH/vendor/KORD/src/Filtration/CallbackSrc.php [ 94 ] in file:line
2014-07-09 18:01:44 --- DEBUG: #0 [internal function]: KORD\CoreSrc::errorHandler(2048, 'call_user_func_...', '/var/www/kord/s...', 94, Array)
#1 /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php(94): call_user_func_array(Array, Array)
#2 /var/www/kord/system/vendor/KORD/src/FiltrationSrc.php(183): KORD\Filtration\CallbackSrc->filter('no')
#3 /var/www/kord/application/classes/Controller/WelcomeController.php(18): KORD\FiltrationSrc->filter(Array)
#4 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#5 [internal function]: KORD\ControllerSrc->execute()
#6 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#7 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#8 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#9 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#10 {main} in file:line
2014-07-09 18:26:08 --- EMERGENCY: ErrorException [ 8 ]: Array to string conversion ~ SYSPATH/vendor/KORD/src/Filtration/HtmlEntitiesSrc.php [ 87 ] in /var/www/kord/system/vendor/KORD/src/Filtration/HtmlEntitiesSrc.php:87
2014-07-09 18:26:08 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/HtmlEntitiesSrc.php(87): KORD\CoreSrc::errorHandler(8, 'Array to string...', '/var/www/kord/s...', 87, Array)
#1 /var/www/kord/system/vendor/KORD/src/Filtration/HtmlEntitiesSrc.php(41): KORD\Filtration\HtmlEntitiesSrc->setEncoding(Array)
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(16): KORD\Filtration\HtmlEntitiesSrc->__construct(Array, Array)
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/HtmlEntitiesSrc.php:87
2014-07-09 18:27:28 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Filtration\HtmlEntities::setMatchPattern() ~ APPPATH/classes/Controller/WelcomeController.php [ 16 ] in file:line
2014-07-09 18:27:28 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-09 18:27:50 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Filtration\PregReplace::setMatchPattern() ~ APPPATH/classes/Controller/WelcomeController.php [ 16 ] in file:line
2014-07-09 18:27:50 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-09 18:28:04 --- EMERGENCY: ErrorException [ 2 ]: preg_replace(): Delimiter must not be alphanumeric or backslash ~ SYSPATH/vendor/KORD/src/Filtration/PregReplaceSrc.php [ 130 ] in file:line
2014-07-09 18:28:04 --- DEBUG: #0 [internal function]: KORD\CoreSrc::errorHandler(2, 'preg_replace():...', '/var/www/kord/s...', 130, Array)
#1 /var/www/kord/system/vendor/KORD/src/Filtration/PregReplaceSrc.php(130): preg_replace(Array, Array, 'Hi bob!')
#2 /var/www/kord/system/vendor/KORD/src/FiltrationSrc.php(183): KORD\Filtration\PregReplaceSrc->filter('Hi bob!')
#3 /var/www/kord/application/classes/Controller/WelcomeController.php(19): KORD\FiltrationSrc->filter(Array)
#4 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#5 [internal function]: KORD\ControllerSrc->execute()
#6 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#7 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#8 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#9 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#10 {main} in file:line
2014-07-09 18:40:30 --- EMERGENCY: ErrorException [ 8 ]: Undefined property: KORD\Filtration\StringToLower::$encoding ~ SYSPATH/vendor/KORD/src/Filtration/StringToLowerSrc.php [ 66 ] in /var/www/kord/system/vendor/KORD/src/Filtration/StringToLowerSrc.php:66
2014-07-09 18:40:30 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/StringToLowerSrc.php(66): KORD\CoreSrc::errorHandler(8, 'Undefined prope...', '/var/www/kord/s...', 66, Array)
#1 /var/www/kord/system/vendor/KORD/src/FiltrationSrc.php(183): KORD\Filtration\StringToLowerSrc->filter('SAMPLE')
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(18): KORD\FiltrationSrc->filter(Array)
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/StringToLowerSrc.php:66