<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2014-07-07 12:15:04 --- EMERGENCY: ErrorException [ 1 ]: Cannot use object of type KORD\Validation as array ~ SYSPATH/vendor/KORD/src/ArrSrc.php [ 250 ] in file:line
2014-07-07 12:15:04 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-07 12:15:50 --- EMERGENCY: ErrorException [ 1 ]: Cannot use object of type KORD\Validation as array ~ SYSPATH/vendor/KORD/src/ArrSrc.php [ 250 ] in file:line
2014-07-07 12:15:50 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-07 12:16:28 --- EMERGENCY: ErrorException [ 1 ]: Cannot use object of type KORD\Validation as array ~ SYSPATH/vendor/KORD/src/ArrSrc.php [ 250 ] in file:line
2014-07-07 12:16:28 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-07 12:17:33 --- EMERGENCY: ErrorException [ 1 ]: Cannot use object of type KORD\Validation as array ~ SYSPATH/vendor/KORD/src/ArrSrc.php [ 250 ] in file:line
2014-07-07 12:17:33 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-07 12:17:34 --- EMERGENCY: ErrorException [ 1 ]: Cannot use object of type KORD\Validation as array ~ SYSPATH/vendor/KORD/src/ArrSrc.php [ 250 ] in file:line
2014-07-07 12:17:34 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-07 12:18:42 --- EMERGENCY: ErrorException [ 1 ]: Cannot use object of type KORD\Validation as array ~ SYSPATH/vendor/KORD/src/ArrSrc.php [ 250 ] in file:line
2014-07-07 12:18:42 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-07 12:18:43 --- EMERGENCY: ErrorException [ 1 ]: Cannot use object of type KORD\Validation as array ~ SYSPATH/vendor/KORD/src/ArrSrc.php [ 250 ] in file:line
2014-07-07 12:18:43 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-07 12:19:38 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Validation\NotEmpty::getType() ~ SYSPATH/vendor/KORD/src/Validation/NotEmptySrc.php [ 117 ] in file:line
2014-07-07 12:19:38 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-07 12:20:23 --- EMERGENCY: ErrorException [ 4096 ]: Object of class KORD\Validation\NotEmpty could not be converted to string ~ SYSPATH/vendor/KORD/src/ValidationSrc.php [ 484 ] in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:484
2014-07-07 12:20:23 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(484): KORD\CoreSrc::errorHandler(4096, 'Object of class...', '/var/www/kord/s...', 484, Array)
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(21): KORD\ValidationSrc->getErrors()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:484
2014-07-07 12:21:17 --- EMERGENCY: ErrorException [ 4096 ]: Object of class KORD\Validation\NotEmpty could not be converted to string ~ SYSPATH/vendor/KORD/src/ValidationSrc.php [ 485 ] in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:485
2014-07-07 12:21:17 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(485): KORD\CoreSrc::errorHandler(4096, 'Object of class...', '/var/www/kord/s...', 485, Array)
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(21): KORD\ValidationSrc->getErrors()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:485
2014-07-07 12:21:52 --- EMERGENCY: ErrorException [ 4096 ]: Object of class KORD\Validation\NotEmpty could not be converted to string ~ SYSPATH/vendor/KORD/src/ValidationSrc.php [ 485 ] in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:485
2014-07-07 12:21:52 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(485): KORD\CoreSrc::errorHandler(4096, 'Object of class...', '/var/www/kord/s...', 485, Array)
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(21): KORD\ValidationSrc->getErrors()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:485
2014-07-07 14:45:13 --- EMERGENCY: ErrorException [ 8 ]: Array to string conversion ~ SYSPATH/vendor/KORD/src/I18nSrc.php [ 97 ] in file:line
2014-07-07 14:45:13 --- DEBUG: #0 [internal function]: KORD\CoreSrc::errorHandler(8, 'Array to string...', '/var/www/kord/s...', 97, Array)
#1 /var/www/kord/system/vendor/KORD/src/I18nSrc.php(97): strtr('.test.isEmpty', Array)
#2 /var/www/kord/system/vendor/KORD/src/I18nSrc.php(228): KORD\I18nSrc->translate('.test.isEmpty', NULL, Array, 'en-us')
#3 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(565): __('.test.isEmpty', NULL, Array, NULL)
#4 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(528): KORD\ValidationSrc->translate('.test.isEmpty', NULL, Array, true)
#5 /var/www/kord/application/classes/Controller/WelcomeController.php(21): KORD\ValidationSrc->getErrors()
#6 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#7 [internal function]: KORD\ControllerSrc->execute()
#8 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#9 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#10 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#11 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#12 {main} in file:line
2014-07-07 14:45:22 --- EMERGENCY: ErrorException [ 8 ]: Array to string conversion ~ SYSPATH/vendor/KORD/src/I18nSrc.php [ 97 ] in file:line
2014-07-07 14:45:22 --- DEBUG: #0 [internal function]: KORD\CoreSrc::errorHandler(8, 'Array to string...', '/var/www/kord/s...', 97, Array)
#1 /var/www/kord/system/vendor/KORD/src/I18nSrc.php(97): strtr('.test.isEmpty', Array)
#2 /var/www/kord/system/vendor/KORD/src/I18nSrc.php(228): KORD\I18nSrc->translate('.test.isEmpty', NULL, Array, 'en-us')
#3 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(565): __('.test.isEmpty', NULL, Array, NULL)
#4 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(528): KORD\ValidationSrc->translate('.test.isEmpty', NULL, Array, true)
#5 /var/www/kord/application/classes/Controller/WelcomeController.php(21): KORD\ValidationSrc->getErrors()
#6 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#7 [internal function]: KORD\ControllerSrc->execute()
#8 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#9 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#10 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#11 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#12 {main} in file:line
2014-07-07 15:46:26 --- EMERGENCY: ErrorException [ 4096 ]: Argument 1 passed to KORD\FiltrationSrc::__construct() must be of the type array, none given, called in /var/www/kord/application/classes/Controller/WelcomeController.php on line 15 and defined ~ SYSPATH/vendor/KORD/src/FiltrationSrc.php [ 33 ] in /var/www/kord/system/vendor/KORD/src/FiltrationSrc.php:33
2014-07-07 15:46:26 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/FiltrationSrc.php(33): KORD\CoreSrc::errorHandler(4096, 'Argument 1 pass...', '/var/www/kord/s...', 33, Array)
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(15): KORD\FiltrationSrc->__construct()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/FiltrationSrc.php:33
2014-07-07 16:00:19 --- EMERGENCY: ErrorException [ 2048 ]: Non-static method KORD\I18nSrc::lang() should not be called statically, assuming $this from incompatible context ~ SYSPATH/vendor/KORD/src/Filtration/AlnumSrc.php [ 53 ] in /var/www/kord/system/vendor/KORD/src/Filtration/AlnumSrc.php:53
2014-07-07 16:00:19 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/AlnumSrc.php(53): KORD\CoreSrc::errorHandler(2048, 'Non-static meth...', '/var/www/kord/s...', 53, Array)
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(16): KORD\Filtration\AlnumSrc->__construct()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/AlnumSrc.php:53
2014-07-07 16:44:57 --- EMERGENCY: ErrorException [ 1 ]: "static::" is not allowed in compile-time constants ~ SYSPATH/vendor/KORD/src/FiltrationSrc.php [ 38 ] in file:line
2014-07-07 16:44:57 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-07 16:47:00 --- EMERGENCY: ErrorException [ 1 ]: "static::" is not allowed in compile-time constants ~ SYSPATH/vendor/KORD/src/FiltrationSrc.php [ 38 ] in file:line
2014-07-07 16:47:00 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-07 16:53:21 --- EMERGENCY: ErrorException [ 8 ]: Array to string conversion ~ SYSPATH/vendor/KORD/src/Filtration/AlnumSrc.php [ 101 ] in /var/www/kord/system/vendor/KORD/src/Filtration/AlnumSrc.php:101
2014-07-07 16:53:21 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/AlnumSrc.php(101): KORD\CoreSrc::errorHandler(8, 'Array to string...', '/var/www/kord/s...', 101, Array)
#1 /var/www/kord/system/vendor/KORD/src/FiltrationSrc.php(182): KORD\Filtration\AlnumSrc->filter(Array)
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(18): KORD\FiltrationSrc->filter(Array)
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/AlnumSrc.php:101
2014-07-07 17:06:02 --- EMERGENCY: ErrorException [ 1 ]: "static::" is not allowed in compile-time constants ~ SYSPATH/vendor/KORD/src/Validation/NotEmptySrc.php [ 25 ] in file:line
2014-07-07 17:06:02 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-07 17:09:57 --- EMERGENCY: ErrorException [ 2 ]: Invalid argument supplied for foreach() ~ SYSPATH/vendor/KORD/src/ValidationSrc.php [ 362 ] in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:362
2014-07-07 17:09:57 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(362): KORD\CoreSrc::errorHandler(2, 'Invalid argumen...', '/var/www/kord/s...', 362, Array)
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(27): KORD\ValidationSrc->check()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:362
2014-07-07 17:10:45 --- EMERGENCY: ErrorException [ 2 ]: Invalid argument supplied for foreach() ~ SYSPATH/vendor/KORD/src/ValidationSrc.php [ 362 ] in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:362
2014-07-07 17:10:45 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(362): KORD\CoreSrc::errorHandler(2, 'Invalid argumen...', '/var/www/kord/s...', 362, Array)
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(27): KORD\ValidationSrc->check()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:362
2014-07-07 17:12:58 --- EMERGENCY: ErrorException [ 2 ]: Invalid argument supplied for foreach() ~ SYSPATH/vendor/KORD/src/ValidationSrc.php [ 363 ] in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:363
2014-07-07 17:12:58 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(363): KORD\CoreSrc::errorHandler(2, 'Invalid argumen...', '/var/www/kord/s...', 363, Array)
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(27): KORD\ValidationSrc->check()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:363
2014-07-07 17:15:24 --- EMERGENCY: ErrorException [ 2 ]: Invalid argument supplied for foreach() ~ SYSPATH/vendor/KORD/src/ValidationSrc.php [ 363 ] in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:363
2014-07-07 17:15:24 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(363): KORD\CoreSrc::errorHandler(2, 'Invalid argumen...', '/var/www/kord/s...', 363, Array)
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(27): KORD\ValidationSrc->check()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:363
2014-07-07 17:26:25 --- EMERGENCY: ErrorException [ 4 ]: syntax error, unexpected ')' ~ APPPATH/classes/Controller/WelcomeController.php [ 24 ] in file:line
2014-07-07 17:26:25 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line