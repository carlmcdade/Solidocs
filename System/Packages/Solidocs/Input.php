<?php
class Solidocs_Input
{
	/**
	 * Has cookie
	 *
	 * @param string
	 * @return bool
	 */
	public function has_cookie($key){
		return (isset($_COOKIE[$key]));
	}
	
	/**
	 * Has get
	 *
	 * @param string
	 * @return bool
	 */
	public function has_get($key){
		return (isset($_GET[$key]));
	}
	
	/**
	 * Has post
	 *
	 * @param string
	 * @return bool
	 */
	public function has_post($key){
		return (isset($_POST[$key]));
	}
	
	/**
	 * Cookie
	 *
	 * @param string
	 * @param mixed		Optional.
	 * @return mixed
	 */
	public function cookie($key, $default = null){
		if(isset($_COOKIE[$key])){
			return $_COOKIE[$key];
		}
		
		return $default;
	}
	
	/**
	 * Get
	 *
	 * @param string
	 * @param mixed		Optional.
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
	 * @param mixed		Optional.
	 * @return mixed
	 */
	public function post($key, $default = null){
		if(isset($_POST[$key])){
			return $_POST[$key];
		}
		
		return $default;
	}
	
	/**
	 * Set cookie
	 *
	 * @param string
	 * @param mixed
	 * @param integer	Optional.
	 */
	public function set_cookie($key, $val, $expire = 3600){
		setcookie($key, $val, time() + $expire);
	}
	
	/**
	 * Unset cookie
	 *
	 * @param string
	 */
	public function unset_cookie($key){
		setcookie($key, '', 1000000000);
	}
}