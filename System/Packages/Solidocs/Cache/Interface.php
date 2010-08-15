<?php
/**
 * Cache Adapter Interface
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
interface Solidocs_Cache_Interface
{
	/**
	 * Connect
	 */
	public function connect();
	
	/**
	 * Close
	 */
	public function close();
	
	/**
	 * Exists
	 *
	 * @param string
	 */
	public function exists($key);
	
	/**
	 * Get
	 *
	 * @param string
	 */
	public function get($key);
	
	/**
	 * Store
	 *
	 * @param string
	 * @param mixed
	 * @param integer	Optional.
	 */
	public function store($key, $val, $expire = 600);
	
	/**
	 * Increment
	 *
	 * @param string
	 * @param integer
	 */
	public function increment($key, $val = 1);
	
	/**
	 * Decrement
	 *
	 * @param string
	 * @param integer
	 */
	public function decrement($key, $val = 1);
	
	/**
	 * Delete
	 *
	 * @param string
	 */
	public function delete($key);
	
	/**
	 * Flush
	 */
	public function flush();
}