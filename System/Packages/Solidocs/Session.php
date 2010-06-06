<?php
class Solidocs_Session
{
	/**
	 * Constructor
	 */
	public function __construct(){
		foreach($_SESSION as $key => $val){
			if(!is_string($val)){
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
	}
	
	/**
	 * Destroy
	 */
	public function destroy(){
		session_destroy();
	}
}