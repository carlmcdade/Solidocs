<?php
/**
 * Cache
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Solidocs_Cache extends Solidocs_Base
{
	/**
	 * Adapter
	 */
	public $adapter = 'File';
	
	/**
	 * Instance
	 */
	public $instance;
	
	/**
	 * Init
	 */
	public function init(){
		$this->instance = $this->load->get_library('Cache_' . $this->adapter);
	}
	
	/**
	 * Call
	 *
	 * @param string
	 * @param array
	 */
	public function __call($method, $params){
		return call_user_func_array(array($this->instance, $method), $params);
	}
}