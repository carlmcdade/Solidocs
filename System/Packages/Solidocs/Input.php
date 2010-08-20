<?php
/**
 * Input
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Solidocs_Input
{
	/**
	 * Constructor
	 */
	public function __construct(){
		// Fix multidimensional $_FILES and remove empty files
		if(count($_FILES) !== 0){
			$files = array();
			
			foreach($_FILES as $parent_key => $items){
				foreach($items as $item => $val){
					if(is_array($val)){
						foreach($val as $sub_key => $sub_val){
							if(!empty($_FILES[$parent_key]['name'][$sub_key])){
								$files[$parent_key][$sub_key][$item] = $sub_val;	
							}
						}
					}
					else{
						$files[$parent_key] = $val;
					}
				}
			}
			
			$_FILES = $files;
		}
	}
	
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
	 * Has file
	 *
	 * @param string	Optional.
	 * @return bool
	 */
	public function has_file($key = ''){
		if(empty($key)){
			return (count($_FILES) !== 1);
		}
		
		return $this->_has($_FILES, $key);
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
	 * File
	 *
	 * @param string
	 * @param mixed		Optional.
	 * @return array|bool
	 */
	public function file($key, $default = null){
		return $this->_get($_FILES, $key, $default);
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
	
	/**
	 * Get os
	 *
	 * @return string|bool
	 */
	public function get_os(){
		$os_list = array(
			'Windows'		=> 'windows',
			'Linux'			=> 'linux',
			'iPhone'		=> 'iphone',
			'iPod'			=> 'ipod',
			'iPad'			=> 'ipad',
			'BlackBerry'	=> 'blackberry',
			'Nokia'			=> 'nokia',
			'Mac OS'		=> 'mac'
		);
		
		foreach($os_list as $strpos => $os){
			if(strpos($_SERVER['HTTP_USER_AGENT'], $strpos)){
				return $os;
			}
		}
		
		return false;
	}
	
	/**
	 * Get browser
	 *
	 * @return string|bool
	 */
	public function get_browser(){
		$browser_list = array(
			'Opera'						=> 'opera',
			'Opera Mini'				=> 'operamini',
			'WebTV'						=> 'webtv',
			'Internet Explorer'			=> 'ie',
			'Pocket Internet Explorer'	=> 'pocketie',
			'Konqueror'					=> 'konqueror',
			'iCab'						=> 'icab',
			'OmniWeb'					=> 'omniweb',
			'Firebird'					=> 'firebird',
			'Firefox'					=> 'firefox',
			'Iceweasel'					=> 'iceweasel',
			'Lynx'						=> 'lynx',
			'iPhone'					=> 'iphone',
			'iPod'						=> 'ipod',
			'iPad'						=> 'ipad',
			'Chrome'					=> 'chrome',
			'Android'					=> 'android',
			'BlackBerry'				=> 'blackberry',
			'Nokia S60'					=> 'nokias60',
			'Nokia Browser'				=> 'nokia',
			'Safari'					=> 'safari',
			'Mozilla'					=> 'mozilla',
		);
		
		foreach($browser_list as $strpos => $browser){
			if(strpos($_SERVER['HTTP_USER_AGENT'], $strpos)){
				return $browser;
			}
		}
		
		return false;
	}
}