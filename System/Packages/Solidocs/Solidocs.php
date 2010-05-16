<?php
class Solidocs
{
	/**
	 * Registry
	 */
	public static $registry;
	
	/**
	 * Application
	 */
	public static $application;
	
	/**
	 * Start
	 */
	public static function start(){
		// Include Solidocs Functions, Base and Application classes
		include(PACKAGE.	'/Solidocs/Functions.php');
		include(PACKAGE.	'/Solidocs/Base.php');
		include(PACKAGE.	'/Solidocs/Application.php');
		include(APP.		'/Application.php');
				
		// Setup registry
		Solidocs::$registry = (object) array();
		
		// Application instance
		self::$application = new Application_Application;
	}
	
	/**
	 * Apply config
	 *
	 * @param object
	 * @param array
	 */
	public static function apply_config($obj,$config){
		foreach($config as $key=>$val){
			$obj->$key = $val;
		}
	}
}