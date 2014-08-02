<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2014-07-24 15:19:38 --- EMERGENCY: KORD\ORM\Exception [ 0 ]: The 'title' property does not exist in the 'Application\Model\TestModel' class ~ MODPATH/orm/vendor/KORD/src/ORMSrc.php [ 595 ] in /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php:550
2014-07-24 15:19:38 --- DEBUG: #0 /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php(550): KORD\ORMSrc->set('title', 'TestLine')
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(25): KORD\ORMSrc->__set('title', 'TestLine')
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php:550
2014-07-24 15:38:17 --- EMERGENCY: KORD\ORM\Exception [ 0 ]: The 'bars' property does not exist in the 'Application\Model\TestModel' class ~ MODPATH/orm/vendor/KORD/src/ORMSrc.php [ 536 ] in /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php:468
2014-07-24 15:38:17 --- DEBUG: #0 /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php(468): KORD\ORMSrc->get('bars')
#1 /var/www/kord/application/classes/Controller/WelcomeController.php(26): KORD\ORMSrc->__get('bars')
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/modules/orm/vendor/KORD/src/ORMSrc.php:468
2014-07-24 16:46:05 --- EMERGENCY: ErrorException [ 4 ]: syntax error, unexpected '->' (T_OBJECT_OPERATOR) ~ APPPATH/classes/Controller/WelcomeController.php [ 28 ] in file:line
2014-07-24 16:46:05 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line