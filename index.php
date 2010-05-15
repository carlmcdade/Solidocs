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
define('ROOT',		getcwd());
define('SYS',		ROOT.	'/System');
define('APP',		SYS.	'/Application');
define('PACKAGE',	SYS.	'/Packages');

/**
 * Include Solidocs Functions, Registry, Base and Application
 */
include(PACKAGE.	'/Solidocs/Functions.php');
include(PACKAGE.	'/Solidocs/Solidocs.php');
include(PACKAGE.	'/Solidocs/Base.php');
include(PACKAGE.	'/Solidocs/Application.php');

/**
 * Set up registry
 */
Solidocs::$registry = (object) array();

/**
 * Include Application class
 */
include(APP.		'/Application.php');

/**
 * Application instance
 */
$application = new Application_Application;

Solidocs::$registry->load->model('User_Test');