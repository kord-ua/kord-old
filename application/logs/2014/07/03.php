<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2014-07-03 05:35:01 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\I18n::pluralRulesFactory() ~ SYSPATH/vendor/KORD/src/I18nSrc.php [ 176 ] in file:line
2014-07-03 05:35:01 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 05:35:49 --- EMERGENCY: ErrorException [ 1 ]: Class 'KORD\I18n\Plural\FactorySrc' not found ~ SYSPATH/vendor/KORD/application/I18n/Plural/Factory.php [ 5 ] in file:line
2014-07-03 05:35:49 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 06:02:59 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: time ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 50 ] in /var/www/kord/modules/cms/vendor/KORD/application/Controller.php:50
2014-07-03 06:02:59 --- DEBUG: #0 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(50): KORD\CoreSrc::errorHandler(8, 'Undefined varia...', '/var/www/kord/m...', 50, Array)
#1 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#2 [internal function]: KORD\ControllerSrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#4 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#5 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#6 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#7 {main} in /var/www/kord/modules/cms/vendor/KORD/application/Controller.php:50
2014-07-03 10:25:40 --- EMERGENCY: ErrorException [ 1 ]: Class '\KORD\Database\Driver\MySQLi' not found ~ MODPATH/database/vendor/KORD/src/DatabaseSrc.php [ 70 ] in file:line
2014-07-03 10:25:40 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 12:45:44 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Database\QueryBuilder\Select::param() ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 54 ] in file:line
2014-07-03 12:45:44 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 14:20:15 --- EMERGENCY: ErrorException [ 2 ]: Parameter 2 to mysqli_stmt::bind_param() expected to be a reference, value given ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 117 ] in file:line
2014-07-03 14:20:15 --- DEBUG: #0 [internal function]: KORD\CoreSrc::errorHandler(2, 'Parameter 2 to ...', '/var/www/kord/m...', 117, Array)
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(117): call_user_func_array(Array, Array)
#2 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(221): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, false, Array)
#3 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(61): KORD\Database\QuerySrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#5 [internal function]: KORD\ControllerSrc->execute()
#6 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#7 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#8 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#9 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#10 {main} in file:line
2014-07-03 14:23:28 --- EMERGENCY: ErrorException [ 1 ]: Class 'KORD\Database\Driver\ReflectionClass' not found ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 117 ] in file:line
2014-07-03 14:23:28 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 14:23:35 --- EMERGENCY: ErrorException [ 1 ]: Call to a member function fetch_all() on a non-object ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 146 ] in file:line
2014-07-03 14:23:35 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 14:28:03 --- EMERGENCY: ErrorException [ 1 ]: Call to a member function get_result() on a non-object ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 123 ] in file:line
2014-07-03 14:28:03 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 14:29:52 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method mysqli_stmt::get_result() ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 123 ] in file:line
2014-07-03 14:29:52 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 15:09:07 --- EMERGENCY: ErrorException [ 2 ]: Wrong parameter count for mysqli_stmt::bind_result() ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 154 ] in file:line
2014-07-03 15:09:07 --- DEBUG: #0 [internal function]: KORD\CoreSrc::errorHandler(2, 'Wrong parameter...', '/var/www/kord/m...', 154, Array)
#1 [internal function]: mysqli_stmt->bind_result()
#2 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(154): call_user_func_array(Array, Array)
#3 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(221): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, false, Array)
#4 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(61): KORD\Database\QuerySrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#6 [internal function]: KORD\ControllerSrc->execute()
#7 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#8 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#9 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#10 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#11 {main} in file:line
2014-07-03 15:09:18 --- EMERGENCY: ErrorException [ 8 ]: Undefined offset: 0 ~ MODPATH/database/vendor/KORD/src/Database/Result/CachedSrc.php [ 44 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php:44
2014-07-03 15:09:18 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php(44): KORD\CoreSrc::errorHandler(8, 'Undefined offse...', '/var/www/kord/m...', 44, Array)
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/ResultSrc.php(102): KORD\Database\Result\CachedSrc->current()
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(62): KORD\Database\ResultSrc->asArray()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php:44
2014-07-03 15:10:15 --- EMERGENCY: ErrorException [ 8 ]: Undefined offset: 0 ~ MODPATH/database/vendor/KORD/src/Database/Result/CachedSrc.php [ 44 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php:44
2014-07-03 15:10:15 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php(44): KORD\CoreSrc::errorHandler(8, 'Undefined offse...', '/var/www/kord/m...', 44, Array)
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/ResultSrc.php(102): KORD\Database\Result\CachedSrc->current()
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(62): KORD\Database\ResultSrc->asArray()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php:44
2014-07-03 15:11:58 --- EMERGENCY: ErrorException [ 8 ]: Undefined offset: 0 ~ MODPATH/database/vendor/KORD/src/Database/Result/CachedSrc.php [ 44 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php:44
2014-07-03 15:11:58 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php(44): KORD\CoreSrc::errorHandler(8, 'Undefined offse...', '/var/www/kord/m...', 44, Array)
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/ResultSrc.php(102): KORD\Database\Result\CachedSrc->current()
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(62): KORD\Database\ResultSrc->asArray()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php:44
2014-07-03 15:12:14 --- EMERGENCY: ErrorException [ 8 ]: Undefined offset: 0 ~ MODPATH/database/vendor/KORD/src/Database/Result/CachedSrc.php [ 44 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php:44
2014-07-03 15:12:14 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php(44): KORD\CoreSrc::errorHandler(8, 'Undefined offse...', '/var/www/kord/m...', 44, Array)
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/ResultSrc.php(102): KORD\Database\Result\CachedSrc->current()
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(62): KORD\Database\ResultSrc->asArray()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php:44
2014-07-03 15:14:17 --- EMERGENCY: ErrorException [ 8 ]: Undefined offset: 0 ~ MODPATH/database/vendor/KORD/src/Database/Result/CachedSrc.php [ 44 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php:44
2014-07-03 15:14:17 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php(44): KORD\CoreSrc::errorHandler(8, 'Undefined offse...', '/var/www/kord/m...', 44, Array)
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/ResultSrc.php(102): KORD\Database\Result\CachedSrc->current()
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(62): KORD\Database\ResultSrc->asArray()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php:44
2014-07-03 15:17:31 --- EMERGENCY: ErrorException [ 8 ]: Undefined offset: 0 ~ MODPATH/database/vendor/KORD/src/Database/Result/CachedSrc.php [ 44 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php:44
2014-07-03 15:17:31 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php(44): KORD\CoreSrc::errorHandler(8, 'Undefined offse...', '/var/www/kord/m...', 44, Array)
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/ResultSrc.php(102): KORD\Database\Result\CachedSrc->current()
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(62): KORD\Database\ResultSrc->asArray()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php:44
2014-07-03 15:24:15 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method mysqli_stmt::fetch_row() ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 146 ] in file:line
2014-07-03 15:24:15 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 15:24:17 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method mysqli_stmt::fetch_row() ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 146 ] in file:line
2014-07-03 15:24:17 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 15:24:24 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method mysqli_stmt::fetch_row() ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 146 ] in file:line
2014-07-03 15:24:24 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 15:27:40 --- EMERGENCY: ErrorException [ 1 ]: Call to a member function fetch_row() on a non-object ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 147 ] in file:line
2014-07-03 15:27:40 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 15:28:33 --- EMERGENCY: ErrorException [ 1 ]: Call to a member function fetch() on a non-object ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 147 ] in file:line
2014-07-03 15:28:33 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 15:40:40 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: rows ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 166 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:166
2014-07-03 15:40:40 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(166): KORD\CoreSrc::errorHandler(8, 'Undefined varia...', '/var/www/kord/m...', 166, Array)
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(221): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, false, Array)
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(61): KORD\Database\QuerySrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:166
2014-07-03 15:43:27 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: rows ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 175 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:175
2014-07-03 15:43:27 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(175): KORD\CoreSrc::errorHandler(8, 'Undefined varia...', '/var/www/kord/m...', 175, Array)
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(221): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, false, Array)
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(61): KORD\Database\QuerySrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:175
2014-07-03 15:44:18 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: rows ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 177 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:177
2014-07-03 15:44:18 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(177): KORD\CoreSrc::errorHandler(8, 'Undefined varia...', '/var/www/kord/m...', 177, Array)
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(221): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, false, Array)
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(61): KORD\Database\QuerySrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:177
2014-07-03 15:47:20 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: rows ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 184 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:184
2014-07-03 15:47:20 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(184): KORD\CoreSrc::errorHandler(8, 'Undefined varia...', '/var/www/kord/m...', 184, Array)
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(221): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, false, Array)
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(61): KORD\Database\QuerySrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:184
2014-07-03 15:47:41 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: values ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 172 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:172
2014-07-03 15:47:41 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(172): KORD\CoreSrc::errorHandler(8, 'Undefined varia...', '/var/www/kord/m...', 172, Array)
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(221): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, false, Array)
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(61): KORD\Database\QuerySrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:172
2014-07-03 15:48:47 --- EMERGENCY: ErrorException [ 4096 ]: Argument 1 passed to KORD\Database\Result\CachedSrc::__construct() must be of the type array, boolean given, called in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php on line 181 and defined ~ MODPATH/database/vendor/KORD/src/Database/Result/CachedSrc.php [ 12 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php:12
2014-07-03 15:48:47 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php(12): KORD\CoreSrc::errorHandler(4096, 'Argument 1 pass...', '/var/www/kord/m...', 12, Array)
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(181): KORD\Database\Result\CachedSrc->__construct(true, 'SELECT * FROM t...', Array, false, Array)
#2 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(221): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, false, Array)
#3 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(61): KORD\Database\QuerySrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#5 [internal function]: KORD\ControllerSrc->execute()
#6 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#7 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#8 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#9 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#10 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php:12
2014-07-03 15:52:00 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: row ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 166 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:166
2014-07-03 15:52:00 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(166): KORD\CoreSrc::errorHandler(8, 'Undefined varia...', '/var/www/kord/m...', 166, Array)
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(221): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, false, Array)
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(61): KORD\Database\QuerySrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:166
2014-07-03 15:52:10 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: rows ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 181 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:181
2014-07-03 15:52:10 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(181): KORD\CoreSrc::errorHandler(8, 'Undefined varia...', '/var/www/kord/m...', 181, Array)
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(221): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, false, Array)
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(61): KORD\Database\QuerySrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:181
2014-07-03 15:57:13 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: rows ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 182 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:182
2014-07-03 15:57:13 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(182): KORD\CoreSrc::errorHandler(8, 'Undefined varia...', '/var/www/kord/m...', 182, Array)
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(221): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, false, Array)
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(61): KORD\Database\QuerySrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:182
2014-07-03 16:13:16 --- EMERGENCY: ErrorException [ 8 ]: Undefined offset: 0 ~ MODPATH/database/vendor/KORD/src/Database/Result/CachedSrc.php [ 44 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php:44
2014-07-03 16:13:16 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php(44): KORD\CoreSrc::errorHandler(8, 'Undefined offse...', '/var/www/kord/m...', 44, Array)
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/ResultSrc.php(102): KORD\Database\Result\CachedSrc->current()
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(62): KORD\Database\ResultSrc->asArray()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Result/CachedSrc.php:44
2014-07-03 16:31:15 --- EMERGENCY: ErrorException [ 1 ]: Call to a member function fetch_object() on a non-object ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 205 ] in file:line
2014-07-03 16:31:15 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 16:31:34 --- EMERGENCY: ErrorException [ 1 ]: Call to a member function fetch() on a non-object ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 205 ] in file:line
2014-07-03 16:31:34 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 16:48:15 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Database\Result\Cached::asObject() ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 62 ] in file:line
2014-07-03 16:48:15 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 16:53:54 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Database\Result\Cached::asObject() ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 62 ] in file:line
2014-07-03 16:53:54 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 16:54:39 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Database\Result\Cached::asObject() ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 62 ] in file:line
2014-07-03 16:54:39 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 16:55:38 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Database\Result\Cached::asObject() ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 62 ] in file:line
2014-07-03 16:55:38 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 16:55:49 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Database\Result\Cached::asObject() ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 62 ] in file:line
2014-07-03 16:55:49 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 16:55:49 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Database\Result\Cached::asObject() ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 62 ] in file:line
2014-07-03 16:55:49 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 16:56:07 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Database\QueryBuilder\Select::execute() ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 61 ] in file:line
2014-07-03 16:56:07 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 16:56:45 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Database\Result\Cached::asObject() ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 62 ] in file:line
2014-07-03 16:56:45 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 16:56:57 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Database\Result\Cached::asObject() ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 62 ] in file:line
2014-07-03 16:56:57 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 16:57:02 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Database\Result\Cached::asObject() ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 62 ] in file:line
2014-07-03 16:57:02 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 16:58:53 --- EMERGENCY: ErrorException [ 1 ]: Call to a member function asObject() on a non-object ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 62 ] in file:line
2014-07-03 16:58:53 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 16:58:58 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Database\Result\Cached::asObject() ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 62 ] in file:line
2014-07-03 16:58:58 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 16:59:02 --- EMERGENCY: ErrorException [ 1 ]: Call to a member function asObject() on a non-object ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 62 ] in file:line
2014-07-03 16:59:02 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 17:01:05 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Database\Result\Cached::asObject() ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 62 ] in file:line
2014-07-03 17:01:05 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 17:01:13 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Database\Result\Cached::asObject() ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 62 ] in file:line
2014-07-03 17:01:13 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 17:01:18 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Database\Result\Cached::asObject() ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 62 ] in file:line
2014-07-03 17:01:18 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 17:02:01 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Database\Result\Cached::asObject() ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 62 ] in file:line
2014-07-03 17:02:01 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 17:02:02 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Database\Result\Cached::asObject() ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 62 ] in file:line
2014-07-03 17:02:02 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 17:02:29 --- EMERGENCY: ErrorException [ 1 ]: Call to undefined method KORD\Database\Result\Cached::asObject() ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 62 ] in file:line
2014-07-03 17:02:29 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 17:08:12 --- EMERGENCY: ErrorException [ 1 ]: Class 'KORD\Database\Driver\ReflectionClass' not found ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 210 ] in file:line
2014-07-03 17:08:12 --- DEBUG: #0 [internal function]: KORD\CoreSrc::shutdownHandler()
#1 {main} in file:line
2014-07-03 17:08:28 --- EMERGENCY: ReflectionException [ 0 ]: Class stdClass does not have a constructor, so you cannot pass any constructor arguments ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 216 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:216
2014-07-03 17:08:28 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(216): ReflectionClass->newInstanceArgs(Array)
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(156): KORD\Database\Driver\MySQLiSrc->fetchObject(Object(mysqli_stmt), Array, '\\stdClass')
#2 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(221): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, true, Array)
#3 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(61): KORD\Database\QuerySrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#5 [internal function]: KORD\ControllerSrc->execute()
#6 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#7 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#8 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#9 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#10 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:216
2014-07-03 17:11:08 --- EMERGENCY: ErrorException [ 8 ]: Undefined property: stdClass::$id ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 64 ] in /var/www/kord/modules/cms/vendor/KORD/application/Controller.php:64
2014-07-03 17:11:08 --- DEBUG: #0 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(64): KORD\CoreSrc::errorHandler(8, 'Undefined prope...', '/var/www/kord/m...', 64, Array)
#1 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#2 [internal function]: KORD\ControllerSrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#4 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#5 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#6 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#7 {main} in /var/www/kord/modules/cms/vendor/KORD/application/Controller.php:64
2014-07-03 17:11:21 --- EMERGENCY: ErrorException [ 8 ]: Undefined property: stdClass::$id ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 64 ] in /var/www/kord/modules/cms/vendor/KORD/application/Controller.php:64
2014-07-03 17:11:21 --- DEBUG: #0 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(64): KORD\CoreSrc::errorHandler(8, 'Undefined prope...', '/var/www/kord/m...', 64, Array)
#1 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#2 [internal function]: KORD\ControllerSrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#4 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#5 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#6 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#7 {main} in /var/www/kord/modules/cms/vendor/KORD/application/Controller.php:64
2014-07-03 17:11:45 --- EMERGENCY: ErrorException [ 8 ]: Undefined property: stdClass::$id ~ MODPATH/cms/vendor/KORD/application/Controller.php [ 64 ] in /var/www/kord/modules/cms/vendor/KORD/application/Controller.php:64
2014-07-03 17:11:45 --- DEBUG: #0 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(64): KORD\CoreSrc::errorHandler(8, 'Undefined prope...', '/var/www/kord/m...', 64, Array)
#1 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#2 [internal function]: KORD\ControllerSrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#4 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#5 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#6 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#7 {main} in /var/www/kord/modules/cms/vendor/KORD/application/Controller.php:64
2014-07-03 17:23:29 --- EMERGENCY: KORD\Database\Exception [ HY093 ]: {SQLSTATE[HY093]: Invalid parameter number: Columns/Parameters are 1-based} [ {SELECT * FROM test WHERE title = '?'} ] ~ MODPATH/database/vendor/KORD/src/Database/Driver/PDOSrc.php [ 150 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php:221
2014-07-03 17:23:29 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(221): KORD\Database\Driver\PDOSrc->query(1, 'SELECT * FROM t...', Array, true, Array)
#1 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(64): KORD\Database\QuerySrc->execute()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php:221
2014-07-03 17:29:18 --- EMERGENCY: KORD\Database\Exception [ HY093 ]: {SQLSTATE[HY093]: Invalid parameter number: Columns/Parameters are 1-based} [ {SELECT * FROM test WHERE title = '?'} ] ~ MODPATH/database/vendor/KORD/src/Database/Driver/PDOSrc.php [ 150 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php:221
2014-07-03 17:29:18 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(221): KORD\Database\Driver\PDOSrc->query(1, 'SELECT * FROM t...', Array, true, Array)
#1 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(64): KORD\Database\QuerySrc->execute()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php:221
2014-07-03 17:45:37 --- EMERGENCY: KORD\Database\Exception [ HY093 ]: {SQLSTATE[HY093]: Invalid parameter number: Columns/Parameters are 1-based} [ {SELECT * FROM test WHERE title = ?} ] ~ MODPATH/database/vendor/KORD/src/Database/Driver/PDOSrc.php [ 150 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php:221
2014-07-03 17:45:37 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(221): KORD\Database\Driver\PDOSrc->query(1, 'SELECT * FROM t...', Array, true, Array)
#1 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(64): KORD\Database\QuerySrc->execute()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php:221
2014-07-03 18:02:58 --- EMERGENCY: KORD\Database\Exception [ HY093 ]: {SQLSTATE[HY093]: Invalid parameter number: Columns/Parameters are 1-based} [ {SELECT * FROM test WHERE title = ?} ] ~ MODPATH/database/vendor/KORD/src/Database/Driver/PDOSrc.php [ 150 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php:227
2014-07-03 18:02:58 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(227): KORD\Database\Driver\PDOSrc->query(1, 'SELECT * FROM t...', Array, true, Array)
#1 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(64): KORD\Database\QuerySrc->execute()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php:227
2014-07-03 18:06:12 --- EMERGENCY: KORD\Database\Exception [ 8 ]: {Undefined offset: 1} [ {SELECT * FROM test WHERE title = ?} ] ~ MODPATH/database/vendor/KORD/src/Database/Driver/PDOSrc.php [ 150 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php:236
2014-07-03 18:06:12 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(236): KORD\Database\Driver\PDOSrc->query(1, 'SELECT * FROM t...', Array, true, Array)
#1 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(64): KORD\Database\QuerySrc->execute()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php:236
2014-07-03 18:06:50 --- EMERGENCY: KORD\Database\Exception [ HY093 ]: {SQLSTATE[HY093]: Invalid parameter number: Columns/Parameters are 1-based} [ {SELECT * FROM test WHERE title = ?} ] ~ MODPATH/database/vendor/KORD/src/Database/Driver/PDOSrc.php [ 150 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php:236
2014-07-03 18:06:50 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(236): KORD\Database\Driver\PDOSrc->query(1, 'SELECT * FROM t...', Array, true, Array)
#1 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(62): KORD\Database\QuerySrc->execute()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php:236
2014-07-03 18:08:20 --- EMERGENCY: KORD\Exception [ 0 ]: Invalid parameter number: Columns/Parameters are 1-based ~ MODPATH/database/vendor/KORD/src/Database/QuerySrc.php [ 132 ] in /var/www/kord/modules/cms/vendor/KORD/application/Controller.php:57
2014-07-03 18:08:20 --- DEBUG: #0 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(57): KORD\Database\QuerySrc->setParam(0, 'line1')
#1 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#2 [internal function]: KORD\ControllerSrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#4 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#5 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#6 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#7 {main} in /var/www/kord/modules/cms/vendor/KORD/application/Controller.php:57
2014-07-03 18:09:13 --- EMERGENCY: KORD\Exception [ 0 ]: Invalid parameter number: Columns/Parameters are 1-based ~ MODPATH/database/vendor/KORD/src/Database/QuerySrc.php [ 132 ] in /var/www/kord/modules/cms/vendor/KORD/application/Controller.php:57
2014-07-03 18:09:13 --- DEBUG: #0 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(57): KORD\Database\QuerySrc->setParam(0, 'line1')
#1 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#2 [internal function]: KORD\ControllerSrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#4 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#5 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#6 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#7 {main} in /var/www/kord/modules/cms/vendor/KORD/application/Controller.php:57
2014-07-03 18:09:25 --- EMERGENCY: ReflectionException [ 0 ]: Invocation of method mysqli_stmt::bind_param() failed ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 205 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:205
2014-07-03 18:09:25 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(205): ReflectionMethod->invokeArgs()
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(239): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, true, Array)
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(62): KORD\Database\QuerySrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:205
2014-07-03 18:09:46 --- EMERGENCY: ReflectionException [ 0 ]: Invocation of method mysqli_stmt::bind_param() failed ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 126 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:0
2014-07-03 18:09:46 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(0): ReflectionMethod->invokeArgs()
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(239): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, true, Array)
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(62): KORD\Database\QuerySrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:0
2014-07-03 18:09:47 --- EMERGENCY: ReflectionException [ 0 ]: Invocation of method mysqli_stmt::bind_param() failed ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 126 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:0
2014-07-03 18:09:47 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(0): ReflectionMethod->invokeArgs()
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(239): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, true, Array)
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(62): KORD\Database\QuerySrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:0
2014-07-03 18:09:56 --- EMERGENCY: ReflectionException [ 0 ]: Invocation of method mysqli_stmt::bind_param() failed ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 126 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:0
2014-07-03 18:09:56 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(0): ReflectionMethod->invokeArgs()
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(239): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, true, Array)
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(62): KORD\Database\QuerySrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:0
2014-07-03 18:09:59 --- EMERGENCY: ReflectionException [ 0 ]: Invocation of method mysqli_stmt::bind_param() failed ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 126 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:0
2014-07-03 18:09:59 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(0): ReflectionMethod->invokeArgs()
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(239): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, true, Array)
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(62): KORD\Database\QuerySrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:0
2014-07-03 18:10:10 --- EMERGENCY: ReflectionException [ 0 ]: Invocation of method mysqli_stmt::bind_param() failed ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 126 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:0
2014-07-03 18:10:10 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(0): ReflectionMethod->invokeArgs()
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(239): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, true, Array)
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(62): KORD\Database\QuerySrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:0
2014-07-03 18:12:20 --- EMERGENCY: ReflectionException [ 0 ]: Invocation of method mysqli_stmt::bind_param() failed ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 126 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:0
2014-07-03 18:12:20 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(0): ReflectionMethod->invokeArgs()
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(239): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, true, Array)
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(62): KORD\Database\QuerySrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:0
2014-07-03 18:12:51 --- EMERGENCY: ReflectionException [ 0 ]: Invocation of method mysqli_stmt::bind_param() failed ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 126 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:0
2014-07-03 18:12:51 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(0): ReflectionMethod->invokeArgs()
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(239): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, true, Array)
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(62): KORD\Database\QuerySrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:0
2014-07-03 18:13:09 --- EMERGENCY: ReflectionException [ 0 ]: Invocation of method mysqli_stmt::bind_param() failed ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 126 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:0
2014-07-03 18:13:09 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(0): ReflectionMethod->invokeArgs()
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(239): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, true, Array)
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(62): KORD\Database\QuerySrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:0
2014-07-03 18:17:54 --- EMERGENCY: ReflectionException [ 0 ]: Invocation of method mysqli_stmt::bind_param() failed ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 205 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:205
2014-07-03 18:17:54 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(205): ReflectionMethod->invokeArgs()
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(239): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, true, Array)
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(62): KORD\Database\QuerySrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:205
2014-07-03 18:18:10 --- EMERGENCY: ReflectionException [ 0 ]: Invocation of method mysqli_stmt::bind_param() failed ~ MODPATH/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php [ 205 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:205
2014-07-03 18:18:10 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php(205): ReflectionMethod->invokeArgs()
#1 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(239): KORD\Database\Driver\MySQLiSrc->query(1, 'SELECT * FROM t...', Array, true, Array)
#2 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(62): KORD\Database\QuerySrc->execute()
#3 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#4 [internal function]: KORD\ControllerSrc->execute()
#5 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#6 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#7 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#8 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#9 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/Driver/MySQLiSrc.php:205
2014-07-03 18:23:34 --- EMERGENCY: KORD\Database\Exception [ HY093 ]: {SQLSTATE[HY093]: Invalid parameter number: parameter was not defined} [ {SELECT * FROM test WHERE title = ?} ] ~ MODPATH/database/vendor/KORD/src/Database/Driver/PDOSrc.php [ 150 ] in /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php:239
2014-07-03 18:23:34 --- DEBUG: #0 /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php(239): KORD\Database\Driver\PDOSrc->query(1, 'SELECT * FROM t...', Array, true, Array)
#1 /var/www/kord/modules/cms/vendor/KORD/application/Controller.php(62): KORD\Database\QuerySrc->execute()
#2 /var/www/kord/system/vendor/KORD/src/ControllerSrc.php(88): KORD\Controller->after()
#3 [internal function]: KORD\ControllerSrc->execute()
#4 /var/www/kord/system/vendor/KORD/src/Request/Client/InternalSrc.php(91): ReflectionMethod->invoke(Object(Application\Controller\WelcomeController))
#5 /var/www/kord/system/vendor/KORD/src/Request/ClientSrc.php(116): KORD\Request\Client\InternalSrc->executeRequest(Object(KORD\Request), Object(KORD\Response))
#6 /var/www/kord/system/vendor/KORD/src/RequestSrc.php(606): KORD\Request\ClientSrc->execute(Object(KORD\Request))
#7 /var/www/kord/index.php(119): KORD\RequestSrc->execute()
#8 {main} in /var/www/kord/modules/database/vendor/KORD/src/Database/QuerySrc.php:239