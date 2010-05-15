<?php
class Solidocs
{
	/**
	 * Registry
	 */
	public static $registry;
	 
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