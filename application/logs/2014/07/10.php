<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2014-07-10 03:42:23 --- EMERGENCY: ErrorException [ 8 ]: Undefined index: allowWhiteSpace ~ SYSPATH/vendor/KORD/src/Validation/AlnumSrc.php [ 68 ] in /var/www/kord/system/vendor/KORD/src/Validation/AlnumSrc.php:68
2014-07-10 03:42:23 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Validation/AlnumSrc.php(68): KORD\CoreSrc::errorHandler(8, 'Undefined index...', '/var/www/kord/s...', 68, Array)
#1 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(378): KORD\Validation\AlnumSrc->isValid('')
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(27): KORD\ValidationSrc->check()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Validation/AlnumSrc.php:68
2014-07-10 09:46:53 --- EMERGENCY: ErrorException [ 2 ]: Cannot use a scalar value as an array ~ SYSPATH/vendor/KORD/src/Validation/NotEmptySrc.php [ 74 ] in /var/www/kord/system/vendor/KORD/src/Validation/NotEmptySrc.php:74
2014-07-10 09:46:53 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Validation/NotEmptySrc.php(74): KORD\CoreSrc::errorHandler(2, 'Cannot use a sc...', '/var/www/kord/s...', 74, Array)
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(25): KORD\Validation\NotEmptySrc->__construct(64, 16)
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/Validation/NotEmptySrc.php:74
2014-07-10 09:47:49 --- EMERGENCY: ErrorException [ 2 ]: Cannot use a scalar value as an array ~ SYSPATH/vendor/KORD/src/Validation/NotEmptySrc.php [ 75 ] in /var/www/kord/system/vendor/KORD/src/Validation/NotEmptySrc.php:75
2014-07-10 09:47:49 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Validation/NotEmptySrc.php(75): KORD\CoreSrc::errorHandler(2, 'Cannot use a sc...', '/var/www/kord/s...', 75, Array)
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(25): KORD\Validation\NotEmptySrc->__construct(64, 16)
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/Validation/NotEmptySrc.php:75
2014-07-10 09:48:25 --- EMERGENCY: ErrorException [ 2 ]: Cannot use a scalar value as an array ~ SYSPATH/vendor/KORD/src/Validation/NotEmptySrc.php [ 75 ] in /var/www/kord/system/vendor/KORD/src/Validation/NotEmptySrc.php:75
2014-07-10 09:48:25 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Validation/NotEmptySrc.php(75): KORD\CoreSrc::errorHandler(2, 'Cannot use a sc...', '/var/www/kord/s...', 75, Array)
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(25): KORD\Validation\NotEmptySrc->__construct(64, 16)
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/Validation/NotEmptySrc.php:75
2014-07-10 09:59:27 --- EMERGENCY: ErrorException [ 1 ]: Class 'KORD\Validation\AlphaSrc' not found ~ SYSPATH/vendor/KORD/application/Validation/Alpha.php [ 5 ] in file:line
2014-07-10 09:59:27 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-10 10:25:06 --- EMERGENCY: ErrorException [ 1 ]: Class 'KORD\Validation\BarCodeSrc' not found ~ SYSPATH/vendor/KORD/application/Validation/Barcode.php [ 5 ] in file:line
2014-07-10 10:25:06 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-10 10:25:14 --- EMERGENCY: ErrorException [ 1 ]: Class 'KORD\Validation\Barcode\AbstractAdapter' not found ~ SYSPATH/vendor/KORD/src/Validation/Barcode/EAN13Src.php [ 6 ] in file:line
2014-07-10 10:25:14 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-10 10:25:28 --- EMERGENCY: ErrorException [ 1 ]: Interface 'KORD\Validation\Barcode\AbstractAdapter' not found ~ SYSPATH/vendor/KORD/src/Validation/Barcode/AdapterInterfaceSrc.php [ 6 ] in file:line
2014-07-10 10:25:28 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-10 10:33:21 --- EMERGENCY: ErrorException [ 2 ]: Missing argument 2 for KORD\ValidationSrc::setLabel(), called in /var/www/kord/application/classes/Controller/WelcomeController.php on line 23 and defined ~ SYSPATH/vendor/KORD/src/ValidationSrc.php [ 130 ] in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:130
2014-07-10 10:33:21 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(130): KORD\CoreSrc::errorHandler(2, 'Missing argumen...', '/var/www/kord/s...', 130, Array)
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(23): KORD\ValidationSrc->setLabel('TestLabel')
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:130
2014-07-10 10:33:36 --- EMERGENCY: ErrorException [ 2 ]: Missing argument 2 for KORD\ValidationSrc::setLabel(), called in /var/www/kord/application/classes/Controller/WelcomeController.php on line 23 and defined ~ SYSPATH/vendor/KORD/src/ValidationSrc.php [ 130 ] in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:130
2014-07-10 10:33:36 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(130): KORD\CoreSrc::errorHandler(2, 'Missing argumen...', '/var/www/kord/s...', 130, Array)
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(23): KORD\ValidationSrc->setLabel('TestLabel')
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:130
2014-07-10 10:33:56 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Validation\Barcode::error() ~ SYSPATH/vendor/KORD/src/Validation/BarcodeSrc.php [ 143 ] in file:line
2014-07-10 10:33:56 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-10 13:17:06 --- EMERGENCY: ErrorException [ 1 ]: Class 'Application\Controller\Zend\Validator\CreditCard' not found ~ APPPATH/classes/Controller/WelcomeController.php [ 25 ] in file:line
2014-07-10 13:17:06 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-10 14:26:48 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Validation\Date::setValue() ~ SYSPATH/vendor/KORD/src/Validation/DateSrc.php [ 74 ] in file:line
2014-07-10 14:26:48 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-10 14:27:21 --- EMERGENCY: ErrorException [ 8 ]: Undefined property: KORD\Validation\Date::$format ~ SYSPATH/vendor/KORD/src/Validation/DateSrc.php [ 123 ] in /var/www/kord/system/vendor/KORD/src/Validation/DateSrc.php:123
2014-07-10 14:27:21 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Validation/DateSrc.php(123): KORD\CoreSrc::errorHandler(8, 'Undefined prope...', '/var/www/kord/s...', 123, Array)
#1 /var/www/kord/system/vendor/KORD/src/Validation/DateSrc.php(101): KORD\Validation\DateSrc->convertString('2010-01-32')
#2 /var/www/kord/system/vendor/KORD/src/Validation/DateSrc.php(74): KORD\Validation\DateSrc->convertToDateTime('2010-01-32')
#3 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(383): KORD\Validation\DateSrc->isValid('2010-01-32')
#4 /var/www/kord/application/classes/Controller/WelcomeController.php(27): KORD\ValidationSrc->check()
#5 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#6 [internal function]: KORD\ControllerSrc->execute()
#7 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#8 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#9 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#10 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#11 {main} in /var/www/kord/system/vendor/KORD/src/Validation/DateSrc.php:123
2014-07-10 14:37:29 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Validation\Digits::getValue() ~ SYSPATH/vendor/KORD/src/Validation/DigitsSrc.php [ 23 ] in file:line
2014-07-10 14:37:29 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-10 15:02:41 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Validation\Alpha::error() ~ SYSPATH/vendor/KORD/src/Validation/AlphaSrc.php [ 63 ] in file:line
2014-07-10 15:02:41 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-10 16:00:40 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: temp ~ SYSPATH/vendor/KORD/src/Validation/EmailSrc.php [ 79 ] in /var/www/kord/system/vendor/KORD/src/Validation/EmailSrc.php:79
2014-07-10 16:00:40 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Validation/EmailSrc.php(79): KORD\CoreSrc::errorHandler(8, 'Undefined varia...', '/var/www/kord/s...', 79, Array)
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(25): KORD\Validation\EmailSrc->__construct()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/Validation/EmailSrc.php:79
2014-07-10 16:02:31 --- EMERGENCY: ErrorException [ 1 ]: Class 'KORD\Validation\Ip' not found ~ SYSPATH/vendor/KORD/src/Validation/HostnameSrc.php [ 333 ] in file:line
2014-07-10 16:02:31 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-10 16:03:09 --- EMERGENCY: ErrorException [ 1 ]: Class 'KORD\Validation\Ip' not found ~ SYSPATH/vendor/KORD/src/Validation/HostnameSrc.php [ 333 ] in file:line
2014-07-10 16:03:09 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-10 16:05:31 --- EMERGENCY: ErrorException [ 1 ]: Class 'KORD\Validation\Ip' not found ~ SYSPATH/vendor/KORD/src/Validation/HostnameSrc.php [ 333 ] in file:line
2014-07-10 16:05:31 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-10 16:05:57 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Validation\Hostname::setValue() ~ SYSPATH/vendor/KORD/src/Validation/HostnameSrc.php [ 425 ] in file:line
2014-07-10 16:05:57 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line