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
	 * Cache page
	 */
	public $cache_page = false;
	
	/**
	 * Init
	 */
	public function init(){
		$this->instance = $this->load->get_library('Cache_' . $this->adapter);
	}
	
	/**
	 * Cache page
	 *
	 * @return bool
	 */
	public function cache_page(){
		return $this->cache_page;
	}
	
	/**
	 * Set cache page
	 *
	 * @param bool
	 */
	public function set_cache_page($flag){
		$this->cache_page = $flag;
	}
	
	/**
	 * Key
	 *
	 * @param string
	 * @return string
	 */
	public function _key($key){
		return md5($key);
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
	
	/**
	 * Exists
	 *
	 * @param string
	 */
	public function exists($key){
		return $this->instance->exists($this->_key($key));
	}
	
	/**
	 * Get
	 *
	 * @param string
	 */
	public function get($key){
		return $this->instance->get($this->_key($key));
	}
	
	/**
	 * Store
	 *
	 * @param string
	 * @param mixed
	 * @param integer	Optional.
	 */
	public function store($key, $val, $expire = 600){
		return $this->instance->store($this->_key($key), $val, $expire);
	}
	
	/**
	 * Increment
	 *
	 * @param string
	 * @param integer
	 */
	public function increment($key, $val = 1){
		return $this->instance->increment($this->_key($key), $val);
	}
	
	/**
	 * Decrement
	 *
	 * @param string
	 * @param integer
	 */
	public function decrement($key, $val = 1){
		return $this->instance->decrement($this->_key($key), $val);
	}
	
	/**
	 * Delete
	 *
	 * @param string
	 */
	public function delete($key){
		return $this->instance->delete($this->_key($key));
	}
}