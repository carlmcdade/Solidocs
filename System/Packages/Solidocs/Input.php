<?php
class Solidocs_Input
{
	/**
	 * Get
	 *
	 * @param string
	 * @param mixed
	 * @return mixed
	 */
	public function get($key, $default = null){
		if(isset($_GET[$key])){
			return $_GET[$key];
		}
		
		return $default;
	}
	
	/**
	 * Post
	 *
	 * @param string
	 * @param mixed
	 * @return mixed
	 */
	public function post($key, $default = null){
		if(isset($_POST[$key])){
			return $_POST[$key];
		}
		
		return $default;
	}
}