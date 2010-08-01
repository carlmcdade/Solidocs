<?php
class Solidocs_Input
{
	/**
	 * Has
	 *
	 * @param array
	 * @param string
	 * @return bool
	 */
	public function _has(&$array, $key){
		if(empty($key)){
			return (count($array) !== 0);
		}
		
		if(strpos($key, '[')){
			$key = explode('[', str_replace(']', '', $key));
			
			return isset($array[$key[0]][$key[1]]);
		}
		
		return (isset($array[$key]));
	}
	
	/**
	 * Get
	 *
	 * @param string
	 * @return mixed
	 */
	public function _get(&$array, $key, $default = null){
		if(strpos($key, '[')){
			$key = explode('[', str_replace(']', '', $key));
			
			if(isset($array[$key[0]][$key[1]])){
				return $array[$key[0]][$key[1]];
			}
			
			return $default;
		}
		
		if(isset($array[$key])){
			return $array[$key];
		}
		
		return $default;
	}
	
	/**
	 * Has cookie
	 *
	 * @param string
	 * @return bool
	 */
	public function has_cookie($key){
		return $this->_has($_COOKIE, $key);
	}
	
	/**
	 * Has get
	 *
	 * @param string	Optional.
	 * @return bool
	 */
	public function has_get($key = ''){
		return $this->_has($_GET, $key);
	}
	
	/**
	 * Has post
	 *
	 * @param string	Optional.
	 * @return bool
	 */
	public function has_post($key = ''){
		return $this->_has($_POST, $key);
	}
	
	/**
	 * Has request
	 *
	 * @param string	Optional.
	 * @return bool
	 */
	public function has_request($key = ''){
		if(empty($key)){
			return (count($_REQUEST) !== 1);
		}
		
		return $this->_has($_REQUEST, $key);
	}
	
	/**
	 * Has uri segment
	 *
	 * @param string
	 * @return bool
	 */
	public function has_uri_segment($key){
		return (isset(Solidocs::$registry->router->segment[$key]));
	}
	
	/**
	 * Cookie
	 *
	 * @param string
	 * @param mixed		Optional.
	 * @return mixed
	 */
	public function cookie($key, $default = null){
		return $this->_get($_COOKIE, $key, $default);
	}
	
	/**
	 * Get
	 *
	 * @param string
	 * @param mixed		Optional.
	 * @return mixed
	 */
	public function get($key, $default = null){
		return $this->_get($_GET, $key, $default);
	}
	
	/**
	 * Post
	 *
	 * @param string
	 * @param mixed		Optional.
	 * @return mixed
	 */
	public function post($key, $default = null){
		return $this->_get($_POST, $key, $default);
	}
	
	/**
	 * Request
	 *
	 * @param string
	 * @param mixed		Optional.
	 * @return mixed
	 */
	public function request($key, $default = null){
		return $this->_get($_REQUEST, $key, $default);
	}
	
	/**
	 * Uri segment
	 *
	 * @param string
	 * @param string|integer	Optional.
	 * @return string|integer
	 */
	public function uri_segment($key, $default = null){
		if(isset(Solidocs::$registry->router->segment[$key])){
			return Solidocs::$registry->router->segment[$key];
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
	
	/**
	 * Get ip
	 *
	 * @return string
	 */
	public function get_ip(){
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		
		return $ip;
	}
}