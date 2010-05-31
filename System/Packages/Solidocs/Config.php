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
	 */
	public function get($section){
		if(isset($this->config[$section])){
			return $this->config[$section];
		}
		
		return false;
	}
	
	/**
	 * Load file
	 *
	 * @param string
	 * @param bool		Optional.
	 */
	public function load_file($file, $return = false){
		if(file_exists($file . '.php')){
			return $this->load_php($file . '.php', $return);
		}
		elseif(file_exists($file . '.ini')){
			return $this->load_ini($file . '.ini', $return);
		}
		
		trigger_error('Config file "'.$file.'" could not be loaded');
	}
	
	/**
	 * Load php
	 *
	 * @param string
	 * @param bool		Optional.
	 * @return array
	 */
	public function load_php($file, $return = false){
		include($file);
		
		if(isset($config)){
			if($return){
				return $config;
			}
			
			$this->config = array_merge($this->config, $config);
		}
	}
	
	/**
	 * Ini
	 *
	 * @param string
	 * @param bool		Optional.
	 * @return array
	 */
	public function load_ini($file, $return = false){
		$config = array();
		
		foreach(parse_ini_file($file, true) as $section => $keys){
			foreach($keys as $key => $val){
				$key = explode('.', $key);
				
				switch(count($key)){
					case 1:
						$config[$section][$key[0]] = $val;
					break;
					
					case 2:
						$config[$section][$key[0]][$key[1]] = $val;
					break;
					
					case 3:
						$config[$section][$key[0]][$key[1]][$key[2]] = $val;
					break;
				}
			}
		}
		
		if($return){
			return $config;
		}
		
		$this->config = array_merge($this->config, $config);
	}
}