<?php
define('ENV', 'dev');

define('CORE_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR  . '..' . DIRECTORY_SEPARATOR);
define('PROJECT_PATH',dirname(__FILE__) . DIRECTORY_SEPARATOR);

ini_set('date.timezone', 'Asia/Shanghai');

require CORE_PATH . 'Core/ApiAutoload.php';
Core_ApiAutoload::registerAutoload();
Core_ApiDispatcher::dispatch();
