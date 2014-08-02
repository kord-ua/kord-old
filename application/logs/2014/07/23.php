<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2014-07-23 08:14:14 --- EMERGENCY: ErrorException [ 2 ]: array_fill(): Number of elements must be positive ~ MODPATH/orm/vendor/KORD/src/ORMSrc.php [ 332 ] in file:line
2014-07-23 08:14:14 --- DEBUG: #0 [internal function]: KORD\CoreSrc::errorHandler(2, 'array_fill(): N...', '/var/www/kord/m...', 332, Array)
#1 /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php(332): array_fill(0, 0, NULL)
#2 /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php(295): KORD\ORMSrc->clear()
#3 /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php(192): KORD\ORMSrc->initialize()
#4 /var/www/kord/application/classes/Controller/WelcomeController.php(24): KORD\ORMSrc->__construct()
#5 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#6 [internal function]: KORD\ControllerSrc->execute()
#7 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#8 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#9 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#10 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#11 {main} in file:line
2014-07-23 08:15:47 --- EMERGENCY: KORD\ORM\Exception [ 0 ]: The 'title' property does not exist in the 'Application\Model\TestModel' class ~ MODPATH/orm/vendor/KORD/src/ORMSrc.php [ 595 ] in /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php:550
2014-07-23 08:15:47 --- DEBUG: #0 /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php(550): KORD\ORMSrc->set('title', 'TestLine')
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(25): KORD\ORMSrc->__set('title', 'TestLine')
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php:550
2014-07-23 08:16:43 --- EMERGENCY: KORD\ORM\Exception [ 0 ]: The 'title' property does not exist in the 'Application\Model\TestModel' class ~ MODPATH/orm/vendor/KORD/src/ORMSrc.php [ 595 ] in /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php:550
2014-07-23 08:16:43 --- DEBUG: #0 /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php(550): KORD\ORMSrc->set('title', 'TestLine')
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(25): KORD\ORMSrc->__set('title', 'TestLine')
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php:550
2014-07-23 08:20:43 --- EMERGENCY: KORD\ORM\Exception [ 0 ]: The 'title' property does not exist in the 'Application\Model\TestModel' class ~ MODPATH/orm/vendor/KORD/src/ORMSrc.php [ 595 ] in /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php:550
2014-07-23 08:20:43 --- DEBUG: #0 /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php(550): KORD\ORMSrc->set('title', 'TestLine')
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(25): KORD\ORMSrc->__set('title', 'TestLine')
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php:550
2014-07-23 08:21:02 --- EMERGENCY: KORD\ORM\Exception [ 0 ]: The 'title' property does not exist in the 'Application\Model\TestModel' class ~ MODPATH/orm/vendor/KORD/src/ORMSrc.php [ 595 ] in /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php:550
2014-07-23 08:21:02 --- DEBUG: #0 /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php(550): KORD\ORMSrc->set('title', 'TestLine')
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(25): KORD\ORMSrc->__set('title', 'TestLine')
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php:550
2014-07-23 08:22:12 --- EMERGENCY: KORD\ORM\Exception [ 0 ]: The 'title' property does not exist in the 'Application\Model\TestModel' class ~ MODPATH/orm/vendor/KORD/src/ORMSrc.php [ 595 ] in /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php:550
2014-07-23 08:22:12 --- DEBUG: #0 /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php(550): KORD\ORMSrc->set('title', 'TestLine')
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(25): KORD\ORMSrc->__set('title', 'TestLine')
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php:550
2014-07-23 08:22:42 --- EMERGENCY: KORD\ORM\Exception [ 0 ]: The 'title' property does not exist in the 'Application\Model\TestModel' class ~ MODPATH/orm/vendor/KORD/src/ORMSrc.php [ 595 ] in /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php:550
2014-07-23 08:22:42 --- DEBUG: #0 /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php(550): KORD\ORMSrc->set('title', 'TestLine')
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(25): KORD\ORMSrc->__set('title', 'TestLine')
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php:550