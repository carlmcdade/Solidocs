<?php
class Solidocs_Load extends Solidocs_Base
{
	/**
	 * Searchable
	 */
	public $searchable;
	
	/**
	 * View handler
	 */
	public $view_handler;
	
	/**
	 * Init
	 */
	public function init(){
		spl_autoload_register(array($this, 'autoload'));
		
		$this->searchable = array(
			'Solidocs'		=> PACKAGE . '/Solidocs',
			'Application'	=> APP
		);
	}
	
	/**
	 * Set view handler
	 *
	 * @param array
	 */
	public function set_view_handler($view_handler){
		$this->view_handler = $view_handler;
	}
	
	/**
	 * Autoload
	 *
	 * @param string
	 */
	public function autoload($class){
		include(PACKAGE . '/' . implode('/', explode('_', $class)).'.php');
	}
	
	/**
	 * Search
	 *
	 * @param string
	 * @param string
	 * @param string	Optional.
	 */
	public function search($class, $type = '', $package = null){
		if(!empty($type)){
			$class = $type . '_' . $class;
		}
		
		$file		= implode('/', explode('_', $class)) . '.php';
		$searchable	= $this->searchable;
		
		if(!is_null($package) AND isset($searchable[$package])){
			$searchable = array($package => $searchable[$package]);
		}
		
		foreach($searchable as $prefix=>$path){
			if(file_exists($path.'/'.$file)){
				return array(
					'prefix'	=> $prefix,
					'path'		=> $path.'/'.$file,
					'class'		=> $prefix.'_'.$class,
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
			$class	= $package . '_' . $library;
			$slug	= strtolower($library);
			$config	= null;
			
			if(is_object($this->config)){
				$config	= $this->config->get($class);
			}
			
			Solidocs::$registry->$slug = new $class($config);
			
			if(is_array($config)){
				Solidocs::apply_config(Solidocs::$registry->$slug, $config);
			}
		}
	}
	
	/**
	 * Model
	 *
	 * @param string
	 * @param string	Optional.
	 */
	public function model($class, $package = null){
		$search = $this->search($class, 'Model', $package);
		
		if(is_array($search)){
			include($search['path']);
			$class = $search['class'];
			Solidocs::$registry->model->$search['slug'] = new $class;
		}
		else{
			trigger_error('Model "'.$class.'" could not be loaded');
		}
	}
	
	/**
	 * Controller
	 *
	 * @param string
	 * @param string	Optional.
	 */
	public function controller($class, $package = null){
		$search = $this->search($class, 'Controller', $package);
		
		if(is_array($search)){
			include($search['path']);
			return $search['class'];
		}
		else{
			trigger_error('Controller "'.$class.'" could not be loaded');
		}
	}
	
	/**
	 * View
	 *
	 * @param string
	 * @param array		Optional.
	 * @param string	Optional.
	 */
	public function view($view, $params = null, $package = null){
		$search = $this->search($view, 'View', $package);
		
		if(is_array($search)){
			if(isset($this->view_handler)){
				call_user_func_array($this->view_handler,array(
					$search['path'],
					$params
				));
			}
			else{
				include($search['path']);
			}
		}
		else{
			trigger_error('View "'.$view.'" could not be loaded');
		}
	}
}