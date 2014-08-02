<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2014-07-17 14:43:45 --- EMERGENCY: KORD\Validation\Exception [ 0 ]: Country code '' invalid by ISO 3166-1 or not supported ~ SYSPATH/vendor/KORD/src/Validation/IBANSrc.php [ 127 ] in /var/www/kord/system/vendor/KORD/src/Validation/RuleAbstractSrc.php:111
2014-07-17 14:43:45 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Validation/RuleAbstractSrc.php(111): KORD\Validation\IBANSrc->setCountryCode(false)
#1 /var/www/kord/system/vendor/KORD/src/Validation/RuleAbstractSrc.php(48): KORD\Validation\RuleAbstractSrc->setOptions(Array)
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(32): KORD\Validation\RuleAbstractSrc->__construct(false)
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Validation/RuleAbstractSrc.php:111
2014-07-17 16:21:49 --- EMERGENCY: ErrorException [ 4096 ]: Argument 1 passed to KORD\Validation\InArraySrc::setHaystack() must be of the type array, string given, called in /var/www/kord/system/vendor/KORD/src/Validation/RuleAbstractSrc.php on line 111 and defined ~ SYSPATH/vendor/KORD/src/Validation/InArraySrc.php [ 62 ] in /var/www/kord/system/vendor/KORD/src/Validation/InArraySrc.php:62
2014-07-17 16:21:49 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Validation/InArraySrc.php(62): KORD\CoreSrc::errorHandler(4096, 'Argument 1 pass...', '/var/www/kord/s...', 62, Array)
#1 /var/www/kord/system/vendor/KORD/src/Validation/RuleAbstractSrc.php(111): KORD\Validation\InArraySrc->setHaystack('12345')
#2 /var/www/kord/system/vendor/KORD/src/Validation/RuleAbstractSrc.php(48): KORD\Validation\RuleAbstractSrc->setOptions(Array)
#3 /var/www/kord/application/classes/Controller/WelcomeController.php(32): KORD\Validation\RuleAbstractSrc->__construct(Array)
#4 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#5 [internal function]: KORD\ControllerSrc->execute()
#6 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#7 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#8 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#9 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#10 {main} in /var/www/kord/system/vendor/KORD/src/Validation/InArraySrc.php:62
2014-07-17 16:24:05 --- EMERGENCY: ErrorException [ 8 ]: Undefined property: KORD\Validation\InArray::$strict ~ SYSPATH/vendor/KORD/src/Validation/InArraySrc.php [ 76 ] in /var/www/kord/system/vendor/KORD/src/Validation/InArraySrc.php:76
2014-07-17 16:24:05 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Validation/InArraySrc.php(76): KORD\CoreSrc::errorHandler(8, 'Undefined prope...', '/var/www/kord/s...', 76, Array)
#1 /var/www/kord/system/vendor/KORD/src/Validation/InArraySrc.php(146): KORD\Validation\InArraySrc->getStrict()
#2 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(384): KORD\Validation\InArraySrc->isValid('12345')
#3 /var/www/kord/application/classes/Controller/WelcomeController.php(34): KORD\ValidationSrc->check()
#4 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#5 [internal function]: KORD\ControllerSrc->execute()
#6 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#7 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#8 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#9 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#10 {main} in /var/www/kord/system/vendor/KORD/src/Validation/InArraySrc.php:76