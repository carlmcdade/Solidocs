<?php
/**
 * Error reporting
 */
error_reporting(E_ALL | E_NOTICE | E_STRICT);

/**
 * Display errors
 */
ini_set('display_errors', 1);
 
/**
 * Session start
 */
session_start();

/**
 * Path constants
 */
define('ROOT',	getcwd());
define('SYS',	ROOT.	'/SYSTEM');
define('APP',	SYS.	'/Application');
define('PACK',	SYS.	'/Packages');

/**
 * Include application class
 */
include(APP.'/Application.php');

/**
 * Application instance
 */
$application = new Application_Application;