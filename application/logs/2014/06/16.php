<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2014-06-16 04:10:36 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Response::bbody() ~ APPPATH/classes/Application/Controller/WelcomeController.php [ 14 ] in file:line
2014-06-16 04:10:36 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-16 04:10:49 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Response::bbody() ~ APPPATH/classes/Application/Controller/WelcomeController.php [ 14 ] in file:line
2014-06-16 04:10:49 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-16 04:10:55 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Response::bbody() ~ APPPATH/classes/Application/Controller/WelcomeController.php [ 14 ] in file:line
2014-06-16 04:10:55 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-16 04:11:07 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Response::bbody() ~ APPPATH/classes/Application/Controller/WelcomeController.php [ 14 ] in file:line
2014-06-16 04:11:07 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-16 04:11:29 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Response::bbody() ~ APPPATH/classes/Application/Controller/WelcomeController.php [ 14 ] in file:line
2014-06-16 04:11:29 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-16 04:16:30 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Response::bbody() ~ APPPATH/classes/Application/Controller/WelcomeController.php [ 14 ] in file:line
2014-06-16 04:16:30 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-16 04:18:40 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Response::bbody() ~ APPPATH/classes/Application/Controller/WelcomeController.php [ 14 ] in file:line
2014-06-16 04:18:40 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-16 04:19:52 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Response::bbody() ~ APPPATH/classes/Application/Controller/WelcomeController.php [ 14 ] in file:line
2014-06-16 04:19:52 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-16 04:20:25 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Response::bbody() ~ APPPATH/classes/Application/Controller/WelcomeController.php [ 14 ] in file:line
2014-06-16 04:20:25 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-16 04:21:58 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Response::bbody() ~ APPPATH/classes/Application/Controller/WelcomeController.php [ 14 ] in file:line
2014-06-16 04:21:58 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-16 04:23:13 --- EMERGENCY: KORD\Exception [ 0 ]: The requested view profiler/stat could not be found ~ SYSPATH/classes/KORD/src/ViewSrc.php [ 231 ] in /var/www/kord/system/classes/KORD/src/ViewSrc.php:115
2014-06-16 04:23:13 --- DEBUG: #0 /var/www/kord/system/classes/KORD/src/ViewSrc.php(115): KORD\ViewSrc->setFilename('profiler/stat')
#1 /var/www/kord/application/classes/Application/Controller/WelcomeController.php(14): KORD\ViewSrc->__construct('profiler/stat')
#2 /var/www/kord/system/classes/KORD/src/ControllerSrc.php(85): Application\Controller\WelcomeController->indexAction()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/classes/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/classes/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/classes/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/system/classes/KORD/src/ViewSrc.php:115
2014-06-16 11:17:18 --- EMERGENCY: ErrorException [ 1 ]: Interface 'KORD\Config\Source' not found ~ SYSPATH/vendor/KORD/src/Config/ReaderSrc.php [ 12 ] in file:line
2014-06-16 11:17:18 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-16 11:20:55 --- EMERGENCY: ErrorException [ 4096 ]: Argument 1 passed to KORD\ConfigSrc::attach() must be an instance of KORD\Config\Source, instance of KORD\Config\File\Reader given, called in /var/www/kord/application/bootstrap.php on line 109 and defined ~ SYSPATH/vendor/KORD/src/ConfigSrc.php [ 42 ] in /var/www/kord/system/vendor/KORD/src/ConfigSrc.php:42
2014-06-16 11:20:55 --- DEBUG: #0 /var/www/kord/system/vendor/KORD/src/ConfigSrc.php(42): KORD\CoreSrc::errorHandler(4096, 'Argument 1 pass...', '/var/www/kord/s...', 42, Array)
#1 /var/www/kord/application/bootstrap.php(109): KORD\ConfigSrc->attach(Object(KORD\Config\File\Reader))
#2 /var/www/kord/index.php(106): require('/var/www/kord/a...')
#3 {main} in /var/www/kord/system/vendor/KORD/src/ConfigSrc.php:42
2014-06-16 13:08:12 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Config::set() ~ APPPATH/classes/Controller/WelcomeController.php [ 15 ] in file:line
2014-06-16 13:08:12 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-16 13:08:31 --- EMERGENCY: ErrorException [ 1 ]: Call to protected method KORD\ConfigSrc::write() from context 'KORD\Config\GroupSrc' ~ SYSPATH/vendor/KORD/src/Config/GroupSrc.php [ 128 ] in file:line
2014-06-16 13:08:31 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-16 13:08:54 --- EMERGENCY: ErrorException [ 1 ]: Class 'KORD\Config\File\Core' not found ~ SYSPATH/vendor/KORD/src/Config/File/WriterSrc.php [ 27 ] in file:line
2014-06-16 13:08:54 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line