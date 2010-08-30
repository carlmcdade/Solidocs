<?php
/**
 * Solidocs Index
 *
 * The entry point of the application. All requests goes through this file.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
 
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
 * Application env
 */
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

/**
 * Path constants
 */
define('ROOT',		dirname(__FILE__));
define('SYS',		ROOT.	'/System');
define('APP',		SYS.	'/Application');
define('PACKAGE',	SYS.	'/Packages');
define('MEDIA',		SYS.	'/Media');
define('UPLOAD',	SYS.	'/Upload');

/**
 * Include Solidocs
 */
include(PACKAGE . '/Solidocs/Solidocs.php');

/**
 * Start Solidocs
 */
Solidocs::start();