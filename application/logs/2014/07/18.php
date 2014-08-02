<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2014-07-18 11:18:28 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Validation\ISBN::getValue() ~ SYSPATH/vendor/KORD/src/Validation/ISBNSrc.php [ 126 ] in file:line
2014-07-18 11:18:28 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-18 11:23:31 --- EMERGENCY: KORD\Validation\Exception [ 0 ]: Invalid ISBN type ~ SYSPATH/vendor/KORD/src/Validation/ISBNSrc.php [ 66 ] in /var/www/kord/system/vendor/KORD/src/Validation/RuleAbstractSrc.php:111
2014-07-18 11:23:31 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Validation/RuleAbstractSrc.php(111): KORD\Validation\ISBNSrc->setType('-')
#1 /var/www/kord/system/vendor/KORD/src/Validation/RuleAbstractSrc.php(48): KORD\Validation\RuleAbstractSrc->setOptions(Array)
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(32): KORD\Validation\RuleAbstractSrc->__construct('-')
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Validation/RuleAbstractSrc.php:111
2014-07-18 13:58:12 --- EMERGENCY: ErrorException [ 8 ]: Undefined index: locale ~ SYSPATH/vendor/KORD/src/Validation/PostCodeSrc.php [ 196 ] in /var/www/kord/system/vendor/KORD/src/Validation/PostCodeSrc.php:196
2014-07-18 13:58:12 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Validation/PostCodeSrc.php(196): KORD\CoreSrc::errorHandler(8, 'Undefined index...', '/var/www/kord/s...', 196, Array)
#1 /var/www/kord/system/vendor/KORD/src/Validation/PostCodeSrc.php(277): KORD\Validation\PostCodeSrc->getLocales()
#2 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(384): KORD\Validation\PostCodeSrc->isValid('2-266-11156-7')
#3 /var/www/kord/application/classes/Controller/WelcomeController.php(34): KORD\ValidationSrc->check()
#4 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#5 [internal function]: KORD\ControllerSrc->execute()
#6 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#7 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#8 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#9 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#10 {main} in /var/www/kord/system/vendor/KORD/src/Validation/PostCodeSrc.php:196
2014-07-18 13:58:39 --- EMERGENCY: KORD\Validation\Exception [ 0 ]: Locale must contain a region ~ SYSPATH/vendor/KORD/src/Validation/PostCodeSrc.php [ 297 ] in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:384
2014-07-18 13:58:39 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(384): KORD\Validation\PostCodeSrc->isValid('2-266-11156-7')
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(34): KORD\ValidationSrc->check()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:384
2014-07-18 13:59:03 --- EMERGENCY: KORD\Validation\Exception [ 0 ]: Locale must contain a region ~ SYSPATH/vendor/KORD/src/Validation/PostCodeSrc.php [ 297 ] in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:384
2014-07-18 13:59:03 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(384): KORD\Validation\PostCodeSrc->isValid('2-266-11156-7')
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(34): KORD\ValidationSrc->check()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:384
2014-07-18 13:59:18 --- EMERGENCY: KORD\Validation\Exception [ 0 ]: Locale must contain a region ~ SYSPATH/vendor/KORD/src/Validation/PostCodeSrc.php [ 297 ] in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:384
2014-07-18 13:59:18 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(384): KORD\Validation\PostCodeSrc->isValid('2-266-11156-7')
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(34): KORD\ValidationSrc->check()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:384
2014-07-18 14:00:58 --- EMERGENCY: KORD\Validation\Exception [ 0 ]: Locale must contain a region ~ SYSPATH/vendor/KORD/src/Validation/PostCodeSrc.php [ 297 ] in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:384
2014-07-18 14:00:58 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(384): KORD\Validation\PostCodeSrc->isValid('2-266-11156-7')
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(34): KORD\ValidationSrc->check()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:384
2014-07-18 14:01:52 --- EMERGENCY: KORD\Validation\Exception [ 0 ]: Locale must contain a region ~ SYSPATH/vendor/KORD/src/Validation/PostCodeSrc.php [ 297 ] in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:384
2014-07-18 14:01:52 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(384): KORD\Validation\PostCodeSrc->isValid('2-266-11156-7')
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(34): KORD\ValidationSrc->check()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/vendor/KORD/src/ValidationSrc.php:384
2014-07-18 14:08:44 --- EMERGENCY: ErrorException [ 2 ]: Invalid argument supplied for foreach() ~ SYSPATH/vendor/KORD/src/Validation/PostCodeSrc.php [ 311 ] in /var/www/kord/system/vendor/KORD/src/Validation/PostCodeSrc.php:311
2014-07-18 14:08:44 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Validation/PostCodeSrc.php(311): KORD\CoreSrc::errorHandler(2, 'Invalid argumen...', '/var/www/kord/s...', 311, Array)
#1 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(384): KORD\Validation\PostCodeSrc->isValid('01234')
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(34): KORD\ValidationSrc->check()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Validation/PostCodeSrc.php:311
2014-07-18 15:15:13 --- EMERGENCY: KORD\Validation\Exception [ 0 ]: Internal error parsing the pattern '123' ~ SYSPATH/vendor/KORD/src/Validation/RegexSrc.php [ 48 ] in /var/www/kord/system/vendor/KORD/src/Validation/RuleAbstractSrc.php:111
2014-07-18 15:15:13 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Validation/RuleAbstractSrc.php(111): KORD\Validation\RegexSrc->setPatterns('123')
#1 /var/www/kord/system/vendor/KORD/src/Validation/RuleAbstractSrc.php(48): KORD\Validation\RuleAbstractSrc->setOptions(Array)
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(32): KORD\Validation\RuleAbstractSrc->__construct(Array)
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Validation/RuleAbstractSrc.php:111