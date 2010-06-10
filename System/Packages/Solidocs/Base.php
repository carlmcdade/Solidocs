<?php
class Solidocs_Base
{
	/**
	 * Constructor
	 *
	 * @param array
	 */
	public function __construct($config = ''){
		if(is_array($config)){
			Solidocs::apply_config($this, $config);
		}
		
		$this->init();
	}
	
	/**
	 * Get
	 *
	 * @param string
	 * @return mixed
	 */
	public function __get($key){
		if(isset(Solidocs::$registry->$key)){
			return Solidocs::$registry->$key;
		}
		
		return null;
	}
	
	/**
	 * Init
	 */
	public function init(){
	}
}