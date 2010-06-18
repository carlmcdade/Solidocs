<?php
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
			$this->load_file($file);
		}
	}
	
	/**
	 * Get
	 *
	 * @param string
	 * @param mixed		Optional.
	 * @return mixed
	 */
	public function get($section, $default = false){
		if(isset($this->config[$section])){
			return $this->config[$section];
		}
		
		return $default;
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
		    	$config[$key[0]] = $val;
		    break;
		    
		    case 2:
		    	$config[$key[0]][$key[1]] = $val;
		    break;
		    
		    case 3:
		    	$config[$key[0]][$key[1]][$key[2]] = $val;
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
				
		foreach($array as $key=>$val){
			$this->add(&$config, $key, $val);
		}
		
		$this->config = array_merge($this->config, $config);
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
		
		if(is_array($config)){
			if($return){
				return $config;
			}
			else{
				$this->config = array_merge($this->config, $config);
			}
		}
		else{
			throw new Exception('Config file "'.$file.'" could not be loaded');
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
			if(!is_array($keys)){
				$config[$section] = $keys;
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