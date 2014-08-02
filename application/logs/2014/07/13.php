<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2014-07-13 09:15:44 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: A replacement separator is not set or is not valid!! ~ SYSPATH/vendor/KORD/src/Filtration/Word/WordFilterAbstractSrc.php [ 75 ] in /var/www/kord/system/vendor/KORD/src/Filtration/Word/CamelCaseToSeparatorSrc.php:53
2014-07-13 09:15:44 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/Word/CamelCaseToSeparatorSrc.php(53): KORD\Filtration\Word\WordFilterAbstractSrc->getReplacementSeparator()
#1 /var/www/kord/system/vendor/KORD/src/FiltrationSrc.php(183): KORD\Filtration\Word\CamelCaseToSeparatorSrc->filter('TextNo1')
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(25): KORD\FiltrationSrc->filter(Array)
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/Word/CamelCaseToSeparatorSrc.php:53
2014-07-13 09:15:46 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: A replacement separator is not set or is not valid!! ~ SYSPATH/vendor/KORD/src/Filtration/Word/WordFilterAbstractSrc.php [ 75 ] in /var/www/kord/system/vendor/KORD/src/Filtration/Word/CamelCaseToSeparatorSrc.php:53
2014-07-13 09:15:46 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/Word/CamelCaseToSeparatorSrc.php(53): KORD\Filtration\Word\WordFilterAbstractSrc->getReplacementSeparator()
#1 /var/www/kord/system/vendor/KORD/src/FiltrationSrc.php(183): KORD\Filtration\Word\CamelCaseToSeparatorSrc->filter('TextNo1')
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(25): KORD\FiltrationSrc->filter(Array)
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/Word/CamelCaseToSeparatorSrc.php:53
2014-07-13 09:39:50 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: "1" is not a valid separator. ~ SYSPATH/vendor/KORD/src/Filtration/Word/WordFilterAbstractSrc.php [ 30 ] in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:73
2014-07-13 09:39:50 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(73): KORD\Filtration\Word\WordFilterAbstractSrc->setSearchSeparator(true)
#1 /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php(51): KORD\Filtration\FilterAbstractSrc->setOptions(Array)
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(23): KORD\Filtration\FilterAbstractSrc->__construct(true, '_')
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/FilterAbstractSrc.php:73
2014-07-13 09:39:59 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: A replacement separator is not set or is not valid!! ~ SYSPATH/vendor/KORD/src/Filtration/Word/WordFilterAbstractSrc.php [ 75 ] in /var/www/kord/system/vendor/KORD/src/Filtration/Word/SeparatorToSeparatorSrc.php:23
2014-07-13 09:39:59 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/Word/SeparatorToSeparatorSrc.php(23): KORD\Filtration\Word\WordFilterAbstractSrc->getReplacementSeparator()
#1 /var/www/kord/system/vendor/KORD/src/FiltrationSrc.php(183): KORD\Filtration\Word\SeparatorToSeparatorSrc->filter('text-no-1')
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(25): KORD\FiltrationSrc->filter(Array)
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/Word/SeparatorToSeparatorSrc.php:23
2014-07-13 09:44:51 --- EMERGENCY: KORD\Filtration\Exception [ 0 ]: A search separator is not set or is not valid!! ~ SYSPATH/vendor/KORD/src/Filtration/Word/WordFilterAbstractSrc.php [ 45 ] in /var/www/kord/system/vendor/KORD/src/Filtration/Word/SeparatorToSeparatorSrc.php:22
2014-07-13 09:44:51 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/Filtration/Word/SeparatorToSeparatorSrc.php(22): KORD\Filtration\Word\WordFilterAbstractSrc->getSearchSeparator()
#1 /var/www/kord/system/vendor/KORD/src/FiltrationSrc.php(183): KORD\Filtration\Word\SeparatorToSeparatorSrc->filter('text-no-1')
#2 /var/www/kord/application/classes/Controller/WelcomeController.php(25): KORD\FiltrationSrc->filter(Array)
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/system/vendor/KORD/src/Filtration/Word/SeparatorToSeparatorSrc.php:22