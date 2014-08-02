<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2014-07-14 14:35:58 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: "1" is not a valid separator. ~ SYSPATH/vendor/KORD/src/Filtration/Word/WordFilterAbstractSrc.php [ 30 ] in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:73
2014-07-14 14:35:58 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(73): KORD\Filtration\Word\WordFilterAbstractSrc->setSearchSeparator(true)
#1 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(51): KORD\Filtration\FilterAbstractSrc->setOptions(Array)
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(23): KORD\Filtration\FilterAbstractSrc->__construct(true, '_')
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:73
2014-07-14 14:36:57 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: A replacement separator is not set or is not valid!! ~ SYSPATH/vendor/KORD/src/Filtration/Word/WordFilterAbstractSrc.php [ 75 ] in /var/www/kord/system/vendor/KORD/src/Filtration/Word/SeparatorToSeparatorSrc.php:23
2014-07-14 14:36:57 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/Word/SeparatorToSeparatorSrc.php(23): KORD\Filtration\Word\WordFilterAbstractSrc->getReplacementSeparator()
#1 /var/www/kord/system/vendor/KORD/src/FiltrationSrc.php(183): KORD\Filtration\Word\SeparatorToSeparatorSrc->filter('text_no_1')
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(25): KORD\FiltrationSrc->filter(Array)
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/Word/SeparatorToSeparatorSrc.php:23
2014-07-14 14:57:14 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: The option "0" does not have a matching set0 setter method or options[0] array key ~ SYSPATH/vendor/KORD/src/Filtration/FilterAbstractSrc.php [ 77 ] in /var/www/kord/system/vendor/KORD/src/Validation/AlnumSrc.php:75
2014-07-14 14:57:14 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Validation/AlnumSrc.php(75): KORD\Filtration\FilterAbstractSrc->setOptions(Array)
#1 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(383): KORD\Validation\AlnumSrc->isValid('test@@test')
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(34): KORD\ValidationSrc->check()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Validation/AlnumSrc.php:75
2014-07-14 14:58:42 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: The option "0" does not have a matching set0 setter method or options[0] array key ~ SYSPATH/vendor/KORD/src/Filtration/FilterAbstractSrc.php [ 77 ] in /var/www/kord/system/vendor/KORD/src/Validation/AlnumSrc.php:75
2014-07-14 14:58:42 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Validation/AlnumSrc.php(75): KORD\Filtration\FilterAbstractSrc->setOptions(Array)
#1 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(383): KORD\Validation\AlnumSrc->isValid('test@@test')
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(34): KORD\ValidationSrc->check()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Validation/AlnumSrc.php:75
2014-07-14 15:03:09 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: The option "0" does not have a matching set0 setter method or options[0] array key ~ SYSPATH/vendor/KORD/src/Filtration/FilterAbstractSrc.php [ 77 ] in /var/www/kord/system/vendor/KORD/src/Validation/AlnumSrc.php:75
2014-07-14 15:03:09 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Validation/AlnumSrc.php(75): KORD\Filtration\FilterAbstractSrc->setOptions(Array)
#1 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(383): KORD\Validation\AlnumSrc->isValid('test@@test')
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(34): KORD\ValidationSrc->check()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Validation/AlnumSrc.php:75
2014-07-14 15:09:23 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: The option "0" does not have a matching set0 setter method or options[0] array key ~ SYSPATH/vendor/KORD/src/Filtration/FilterAbstractSrc.php [ 77 ] in /var/www/kord/system/vendor/KORD/src/Validation/AlnumSrc.php:75
2014-07-14 15:09:23 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Validation/AlnumSrc.php(75): KORD\Filtration\FilterAbstractSrc->setOptions(Array)
#1 /var/www/kord/system/vendor/KORD/src/ValidationSrc.php(384): KORD\Validation\AlnumSrc->isValid('test@@test')
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(34): KORD\ValidationSrc->check()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Validation/AlnumSrc.php:75
2014-07-14 15:32:40 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: Invalid parameter for callback: must be callable ~ SYSPATH/vendor/KORD/src/Filtration/CallbackSrc.php [ 48 ] in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:77
2014-07-14 15:32:40 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(77): KORD\Filtration\CallbackSrc->setCallback('Application\\Con...')
#1 /var/www/kord/system/vendor/KORD/src/Filtration/CallbackSrc.php(34): KORD\Filtration\FilterAbstractSrc->setOptions(Array)
#2 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(41): KORD\Filtration\CallbackSrc->setOptions(Array)
#3 /var/www/kord/application/classes/Controller/WelcomeController.php(23): KORD\Filtration\FilterAbstractSrc->__construct(Array)
#4 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#5 [internal function]: KORD\ControllerSrc->execute()
#6 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#7 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#8 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#9 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#10 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:77