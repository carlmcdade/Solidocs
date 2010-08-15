<?php
/**
 * Filesystem Cache
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Solidocs_Cache_File extends Solidocs_Cache_Cache implements Solidocs_Cache_Interface
{
	/**
	 * Path
	 */
	public $path;
	
	/**
	 * Retrieved
	 */
	public $retrieved = array();
	
	/**
	 * Delimiter
	 */
	public $delimiter = '|||||';
	
	/**
	 * Connect
	 */
	public function connect(){
		$this->load->library('File');
		
		if(empty($this->path)){
			$this->path = SYS . '/Cache';
		}
		
		if(!file_exists($this->path)){
			$this->file->mkdir($this->path);
		}
	}
	
	/**
	 * Close
	 */
	public function close(){}
	
	/**
	 * Exists
	 *
	 * @param string
	 */
	public function exists($key){
		if(!file_exists($this->path . '/' . $key . '.php')){
			return false;
		}
		
		$file = explode($this->delimiter, $this->file->get_contents($this->path . '/' . $key . '.php'));
		$expire = $file[0];
		$content = $file[1];
	
		if($expire > time()){
			$this->delete($key);
			return false;
		}
		
		$this->retrieved[$key] = $content;
		
		return true;
	}
	
	/**
	 * Get
	 *
	 * @param string
	 */
	public function get($key){
		if($this->exists($key)){
			return $this->retrieved[$key];
		}
	}
	
	/**
	 * Store
	 *
	 * @param string
	 * @param mixed
	 * @param integer	Optional.
	 */
	public function store($key, $val, $expire = 600){
		$content = time() . $this->delimiter . $val;
		
		$this->file->set_contents($this->path . '/' . $key . '.php', $content);
	}
	
	/**
	 * Increment
	 *
	 * @param string
	 * @param integer
	 */
	public function increment($key, $val = 1){}
	
	/**
	 * Decrement
	 *
	 * @param string
	 * @param integer
	 */
	public function decrement($key, $val = 1){}
	
	/**
	 * Delete
	 *
	 * @param string
	 */
	public function delete($key){}
	
	/**
	 * Flush
	 */
	public function flush(){
		foreach($this->file->dir($this->path) as $file){
			$this->file->delete($this->path . '/' . $file);
		}
	}
}