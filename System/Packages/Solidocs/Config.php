<?php
/**
 * Configuration
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Solidocs_Config
{
	/**
	 * Config
	 */
	public $config = array();
	
	/**
	 * Constructor
	 *
	 * @param string
	 */
	public function __construct($files = false){
		if($files == false){
			return false;
		}
		
		if(!is_array($files)){
			$files = array($files);
		}
		
		foreach($files as $file){
			if($this->file_exists($file)){
				$this->load_file($file);
			}
		}
	}
	
	/**
	 * Get
	 *
	 * @param string
	 * @param mixed		Optional.
	 * @return mixed
	 */
	public function get($key, $default = null){
		$key = explode('.', $key);
		
		if(!isset($this->config[$key[0]])){
			return $default;
		}
		
		$config = $this->config[$key[0]];
		unset($key[0]);
		
		if(count($key) == 0){
			return $config;
		}
		
		foreach($key as $part){
			if(!isset($config[$part])){
				return $default;
			}
			
			$config = $config[$part];
		}
		
		return $config;
	}
	
	/**
	 * Add
	 *
	 * @param string
	 * @param string|integer
	 */
	public function add(&$config, $key, $val){
		$key = explode('.', $key);
		
		switch(count($key)){
			case 1:
				if(isset($config[$key[0]])){
					$config[$key[0]] = array_merge($config[$key[0]], $val);
				}
				else{
					$config[$key[0]] = $val;
				}
			break;
			
			case 2:
				if(isset($config[$key[0]][$key[1]])){
					$config[$key[0]][$key[1]] = array_merge($config[$key[0]][$key[1]], $val);
				}
				else{
					$config[$key[0]][$key[1]] = $val;
				}
			break;
			
			case 3:
				if(isset($config[$key[0]][$key[1]][$key[2]])){
					$config[$key[0]][$key[1]][$key[2]] = array_merge($config[$key[0]][$key[1]][$key[2]], $val);
				}
				else{
					$config[$key[0]][$key[1]][$key[2]] = $val;
				}
			break;
		}
	}
	
	/**
	 * Add array
	 *
	 * @param array
	 */
	public function add_array($array){
		$config = array();
				
		foreach($array as $key => $val){
			$this->add(&$config, $key, $val);
		}
		
		$this->config = array_merge($this->config, $config);
	}
	
	/**
	 * File exists
	 *
	 * @param string
	 * @return bool
	 */
	public function file_exists($file){
		return (file_exists($file . '.php') OR file_exists($file . '.ini') OR file_exists($file . '.xml'));
	}
	
	/**
	 * Array merge
	 *
	 * @param array
	 * @param array
	 */
	public function _array_merge($first, $second){
		foreach($second as $key => $val){
			if(isset($first[$key])){
				if(is_array($first[$key])){
					$first[$key] = $this->_array_merge($first[$key], $val);
				}
				elseif(is_integer($key)){
					array_push($first, $val);
				}
				else{
					$first[$key] = $val;
				}
			}
			else{
				$first[$key] = $val;
			}
		}
		
		return $first;
	}
	
	/**
	 * Load file
	 *
	 * @param string
	 * @param bool		Optional.
	 */
	public function load_file($file, $return = false){
		if(file_exists($file . '.php')){
			$config = $this->load_php($file . '.php');
		}
		elseif(file_exists($file . '.ini')){
			$config = $this->load_ini($file . '.ini');
		}
		elseif(file_exists($file . '.xml')){
			$config = $this->load_xml($file . '.xml');
		}
		
		if(isset($config) AND is_array($config)){
			if($return){
				return $config;
			}
			else{
				$this->config = $this->_array_merge($this->config, $config);
			}
		}
		else{
			throw new Exception('Config file "' . $file . '" could not be loaded');
		}
	}
	
	/**
	 * Load php
	 *
	 * @param string
	 * @return array
	 */
	public function load_php($file){
		include($file);
		
		if(isset($config)){
			return $config;
		}
	}
	
	/**
	 * Ini
	 *
	 * @param string
	 * @return array
	 */
	public function load_ini($file){
		$config = array();
				
		foreach(parse_ini_file($file, true) as $section => $keys){
			if(!is_array($keys) OR strpos($section, '.')){
				$this->add(&$config, $section, $keys);
				continue;
			}
			
			foreach($keys as $key => $val){
				$this->add(&$config[$section], $key, $val);
			}
		}
		
		return $config;
	}
	
	/**
	 * Load XML
	 *
	 * @param string
	 * @return array
	 */
	public function load_xml($file){
		$config = array();
		
		$xml = simplexml_load_file($file);
		
		foreach($xml as $key => $val){
			if(isset($config[$key])){
				$config[$key][] = (string) $val;
			}
			else{
				$config[$key] = (array) $val;
			}
		}
		
		return $config;
	}
}