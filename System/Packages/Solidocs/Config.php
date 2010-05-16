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
	public function __construct($config){
		if(is_array($config)){
			$this->config = $conifg;
		}
		elseif(file_exists($config)){
			$this->load_file($config);
		}
		
		if(isset($this->config['Solidocs_Config'])){
			Solidocs::apply_config($this,$this->get('Solidocs_Config'));
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
	public function load_file($file,$return = false){
		if(!file_exists($file)){
			trigger_error('Config file "'.$file.'" could not be loaded');
			return false;
		}
		
		$ext = explode('.', $file);
		$ext = $ext[count($ext) - 1];
		
		switch($ext){
			case 'ini':
				return $this->load_ini($file,$return);
				break;
			
			case 'php':
				return $this->load_php($file,$return);
				break;
		}
	}
	
	/**
	 * Load php
	 *
	 * @param string
	 * @param bool		Optional.
	 */
	public function load_php($file,$return = false){
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
	 */
	public function load_ini($file,$return = false){
		$config = array();
		
		foreach(parse_ini_file($file, true) as $section=>$keys){
			foreach($keys as $key=>$val){
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