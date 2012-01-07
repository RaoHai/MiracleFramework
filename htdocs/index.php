<?php
header("content-Type: text/html; charset=utf-8");

   
   // error_reporting(0);

    defined('BASE_PATH')  
	|| define('BASE_PATH', realpath(dirname(__FILE__)).'/../');
    defined('APPLICATION_PATH')
	|| define('APPLICATION_PATH', BASE_PATH . '/application');
    defined('APPLICATION_ENV')
        || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
    defined('WEB_ROOT')
        || define('WEB_ROOT', BASE_PATH . 'www');

       

  

session_start();

define("WEB_AUTH",TRUE);

include_once APPLICATION_PATH.'/route.php';

?>