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
	 */
	public function load_file($file){
		$ext = explode('.', $file);
		$ext = $ext[count($ext) - 1];
		
		switch($ext){
			case 'ini':
				$this->load_ini($file);
				break;
			
			case 'php':
				$this->load_php($file);
				break;
		}
	}
	
	/**
	 * Load php
	 *
	 * @param string
	 */
	public function load_php($file){
		include($file);
		
		if(isset($config)){
			$this->config = array_merge($this->config, $config);
		}
	}
	
	/**
	 * Ini
	 *
	 * @param string
	 */
	public function load_ini($file){
		$this->config = array_merge($this->config, parse_ini_file($file, true));
	}
}