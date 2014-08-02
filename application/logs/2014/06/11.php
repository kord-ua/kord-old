<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2014-06-11 12:29:53 --- EMERGENCY: ErrorException [ 4 ]: syntax error, unexpected ' ~ APPPATH/classes/App/Controller/Welcome.php(13) : eval()'d code [ 1 ] in file:line
2014-06-11 12:29:53 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-11 12:31:33 --- EMERGENCY: ErrorException [ 4 ]: syntax error, unexpected ' ~ APPPATH/classes/App/Controller/Welcome.php(13) : eval()'d code [ 1 ] in file:line
2014-06-11 12:31:33 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-11 12:53:14 --- EMERGENCY: ErrorException [ 1 ]: Class 'App\Controller\Core' not found ~ APPPATH/classes/App/Controller/Welcome.php [ 12 ] in file:line
2014-06-11 12:53:14 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-11 13:16:40 --- EMERGENCY: ErrorException [ 1 ]: Class 'KORD\URL' not found ~ SYSPATH/classes/KORD/src/HTMLSrc.php [ 203 ] in file:line
2014-06-11 13:16:40 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-11 13:26:33 --- EMERGENCY: ErrorException [ 1 ]: Class 'KORD\URLSrc' not found ~ SYSPATH/classes/KORD/application/URL.php [ 5 ] in file:line
2014-06-11 13:26:33 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-06-11 13:26:43 --- EMERGENCY: ErrorException [ 2 ]: htmlspecialchars() expects at most 4 parameters, 6 given ~ SYSPATH/views/profiler/test_stats.php [ 30 ] in file:line
2014-06-11 13:26:43 --- DEBUG: #0 [internal function]: KORD\CoreSrc::errorHandler(2, 'htmlspecialchar...', '/var/www/kord/s...', 30, Array)
#1 /var/www/kord/system/views/profiler/test_stats.php(30): htmlspecialchars('&quot;/&quot;', ' (', 1, ')', 3, 'utf-8')
#2 /var/www/kord/system/classes/KORD/src/ViewSrc.php(62): include('/var/www/kord/s...')
#3 /var/www/kord/system/classes/KORD/src/ViewSrc.php(324): KORD\ViewSrc::capture('/var/www/kord/s...', Array)
#4 /var/www/kord/system/classes/KORD/src/ViewSrc.php(213): KORD\ViewSrc->render()
#5 /var/www/kord/system/classes/KORD/src/ResponseSrc.php(163): KORD\ViewSrc->__toString()
#6 /var/www/kord/application/classes/App/Controller/Welcome.php(14): KORD\ResponseSrc->body(Object(KORD\View))
#7 /var/www/kord/system/classes/KORD/src/ControllerSrc.php(85): App\Controller\Welcome->indexAction()
#8 [internal function]: KORD\ControllerSrc->execute()
#9 /var/www/kord/system/classes/KORD/src/Request/Client/InternalSrc.php(97): ReflectionMethod->invoke(Object(App\Controller\Welcome))
#10 /var/www/kord/system/classes/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#11 /var/www/kord/system/classes/KORD/src/RequestSrc.php(455): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#12 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#13 {main} in file:line
2014-06-11 13:27:28 --- EMERGENCY: ErrorException [ 8 ]: Use of undefined constant key - assumed 'key' ~ SYSPATH/views/profiler/test_stats.php [ 32 ] in /var/www/kord/system/views/profiler/test_stats.php:32
2014-06-11 13:27:28 --- DEBUG: #0 /var/www/kord/system/views/profiler/test_stats.php(32): KORD\CoreSrc::errorHandler(8, 'Use of undefine...', '/var/www/kord/s...', 32, Array)
#1 /var/www/kord/system/classes/KORD/src/ViewSrc.php(62): include('/var/www/kord/s...')
#2 /var/www/kord/system/classes/KORD/src/ViewSrc.php(324): KORD\ViewSrc::capture('/var/www/kord/s...', Array)
#3 /var/www/kord/system/classes/KORD/src/ViewSrc.php(213): KORD\ViewSrc->render()
#4 /var/www/kord/system/classes/KORD/src/ResponseSrc.php(163): KORD\ViewSrc->__toString()
#5 /var/www/kord/application/classes/App/Controller/Welcome.php(14): KORD\ResponseSrc->body(Object(KORD\View))
#6 /var/www/kord/system/classes/KORD/src/ControllerSrc.php(85): App\Controller\Welcome->indexAction()
#7 [internal function]: KORD\ControllerSrc->execute()
#8 /var/www/kord/system/classes/KORD/src/Request/Client/InternalSrc.php(97): ReflectionMethod->invoke(Object(App\Controller\Welcome))
#9 /var/www/kord/system/classes/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#10 /var/www/kord/system/classes/KORD/src/RequestSrc.php(455): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#11 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#12 {main} in /var/www/kord/system/views/profiler/test_stats.php:32