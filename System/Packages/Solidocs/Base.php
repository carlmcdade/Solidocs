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
			Solidocs::apply_config($this,$config);
		}
		
		$this->init();
	}
	
	/**
	 * Init
	 */
	public function init(){
	}
}