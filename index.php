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
 * Starttime
 */
define('STARTTIME', microtime());

/**
 * Path constants
 */
define('ROOT',		getcwd());
define('SYS',		ROOT.	'/System');
define('APP',		SYS.	'/Application');
define('PACKAGE',	SYS.	'/Packages');
define('MEDIA',		SYS.	'/Media');

/**
 * Include Solidocs
 */
include(PACKAGE . '/Solidocs/Solidocs.php');

/**
 * Start Solidocs
 */
Solidocs::start();