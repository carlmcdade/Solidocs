<?php
class Solidocs_Load extends Solidocs_Base
{
	/**
	 * Searchable
	 */
	public $searchable;
	
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
	 * @param string	Optional.
	 */
	public function search($class, $package = null){
		$file		= implode('/', explode('_', $class)).'.php';
		$searchable	= $this->searchable;
		
		if(!is_null($package)){
			$searchable = $searchable[$package];
		}
		
		foreach($searchable as $prefix=>$path){
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
	 * @param string	Optional.
	 */
	public function model($class, $package = null){
		$search = $this->search($class, $package);
		
		if(is_array($search)){
			$class = $search['prefix'].'_'.$class;
			Solidocs::$model->$search['slug'] = new $class;
		}
	}
	
	/**
	 * Controller
	 *
	 * @param string
	 * @param string	Optional.
	 */
	public function controller($class, $package = null){
		
	}
	
	/**
	 * View
	 *
	 * @param string
	 * @param array		Optional.
	 * @param string	Optional.
	 */
	public function view($view, $params = null, $package = null){
	
	}
}