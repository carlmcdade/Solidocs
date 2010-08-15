<?php
/**
 * Base
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
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
		
		if($config !== false){
			$this->init();
		}
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