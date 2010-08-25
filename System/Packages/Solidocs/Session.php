<?php
/**
 * Session
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Solidocs_Session
{
	/**
	 * Constructor
	 */
	public function __construct(){
		foreach($_SESSION as $key => $val){
			if(!is_array($val) AND !is_string($val)){
				$val = (object) $val;
			}
			
			$this->{$key} = $val;
		}
	}
	
	/**
	 * Destructor
	 */
	public function __destruct(){
		foreach($this as $key => $val){
			if(is_object($val)){
				$val = (array) $val;
			}
			
			$_SESSION[$key] = $val;
		}
		
		foreach($_SESSION as $key => $val){
			if(!isset($this->{$key})){
				unset($_SESSION[$key]);
			}
		}
	}
	
	/**
	 * Destroy
	 */
	public function destroy(){
		session_destroy();
	}
}