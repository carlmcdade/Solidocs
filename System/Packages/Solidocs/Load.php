<?php
class Solidocs_Load extends Solidocs_Base
{
	/**
	 * Searchable
	 */
	public $searchable;
	
	public $test;
	
	/**
	 * Init
	 */
	public function init(){
		spl_autoload_register(array($this, 'autoload'));
		
		$this->searchable = array(
			'Solidocs'		=> PACKAGE.'/Solidocs',
			'Application'	=> APP
		);
	}
	
	/**
	 * Autoload
	 *
	 * @param string
	 */
	public function autoload($class){
		$path = PACKAGE . '/' . implode('/', explode('_', $class)).'.php';
		
		include($path);
	}
	
	/**
	 * Search
	 *
	 * @param string
	 */
	public function search($class){
		$file = implode('/', explode('_', $class)).'.php';
		
		foreach($this->searchable as $prefix=>$path){
			if(file_exists($path.$file)){
				return array(
					'prefix'	=> $prefix,
					'path'		=> $path,
					'slug'		=> strtolower(str_replace($prefix, '', $class))
				);
			}
		}
		
		return false;
	}
	
	/**
	 * Library
	 *
	 * @param string
	 * @param string|array
	 */
	public function library($package, $libraries){
		if(!is_array($libraries)){
			$libraries = explode(',', $libraries);
		}
		
		foreach($libraries as $library){
			$class	= $package.'_'.$library;
			$config	= null;
			
			if(is_object($this->config)){
				$config	= $this->config->get($class);
			}
			
			Solidocs::$registry->{strtolower($library)} = new $class($config);
		}
	}
	
	/**
	 * Model
	 *
	 * @param string
	 */
	public function model($class){
		$search = $this->search($class);
		
		if(is_array($search)){
			$class = $search['prefix'].'_'.$class;
			Solidocs::$model->$search['slug'] = new $class;
		}
	}
	
	/**
	 * Controller
	 *
	 * @param string
	 */
	public function controller($class){
	
	}
	
	/**
	 * View
	 *
	 * @param string
	 * @param array		Optional.
	 */
	public function view($view, $params = null){
	
	}
}