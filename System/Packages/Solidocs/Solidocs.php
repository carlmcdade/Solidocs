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
		include(PACKAGE . '/Solidocs/Functions.php');
		include(PACKAGE . '/Solidocs/Base.php');
		include(PACKAGE . '/Solidocs/Application.php');
		include(APP		. '/Application.php');
				
		// Setup registry
		Solidocs::$registry = (object) array(
			'locale'	=> 'en_GB',
			'model'		=> (object) array(),
			'helper'	=> (object) array(),
			'plugin'	=> (object) array(),
			'hook'		=> array()
		);
		
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
		if(!is_array($config)){
			return false;
		}
		
		foreach($config as $key=>$val){
			$obj->$key = $val;
		}
	}
	
	/**
	 * Add action
	 *
	 * @param string
	 * @param array
	 */
	public static function add_action($key, $hook){
		foreach(explode(',', $key) as $key){
			self::$registry->hook[$key][] = $hook;
		}
	}
	
	/**
	 * Do action
	 *
	 * @param string
	 * @param array		Optional.
	 * @param bool		Optional.
	 * @return array
	 */
	public static function do_action($keys, $data = null, $is_filter = false){
		if(!is_array($data)){
			$data = array($data);
		}
			
		foreach(explode(',', $keys) as $key){
			if(!isset(self::$registry->hook[$key])){
				return false;
			}
			
			foreach(self::$registry->hook[$key] as $hook){
				if(is_string($hook)){
					$hook = explode('::', $hook);
					
					if(!isset($hook[1])){
						$hook = $hook[0];
					}
				}
				
				if(is_array($hook)){
					if(!is_object($hook[0])){
						$hook[0] = self::$registry->load->plugin($hook[0]);
					}
					
					if(!is_object($hook[0])){
						continue;
					}
				}
				elseif(is_object(self::$registry->load->search($hook))){
					continue;
				}
				elseif(!function_exists($hook)){
					continue;
				}
				
				if($is_filter){
					$data = call_user_func_array($hook, $data);
				}
				else{
					call_user_func_array($hook, $data);
				}
			}
		}
		
		if($is_filter){
			return $data;
		}
	}
	
	/**
	 * Add filter
	 *
	 * @param string
	 * @param array
	 */
	public static function add_filter($key, $hook){
		self::add_action($key, $hook);
	}
	
	/**
	 * Apply filter
	 *
	 * @param string
	 * @param mixed
	 */
	public static function apply_filter($key, $data){
		return self::do_action($key, $data, true);
	}
}