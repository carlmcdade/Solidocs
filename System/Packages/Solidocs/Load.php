<?php
class Solidocs_Load extends Solidocs_Base
{
	/**
	 * Searchable
	 */
	public $searchable = array();
	
	/**
	 * View handler
	 */
	public $view_handler;
	
	/**
	 * L10n view
	 */
	public $localized_view = true;
	
	/**
	 * Init
	 */
	public function init(){
		spl_autoload_register(array($this, 'autoload'));
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
		$class		= ltrim($class, '\\');
		$file		= '';
		$namespace	= '';
		
		if($last_ns_pos = strripos($class, '\\')){
			$namespace	= substr($class, 0, $last_ns_pos);
			$class		= substr($class, $last_ns_pos + 1);
			$file		= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
		}
		
		$file .= str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
		
		include_once(PACKAGE . DIRECTORY_SEPARATOR . $file);
	}
	
	/**
	 * Package
	 *
	 * @param string
	 */
	public function package($package){
		if(!in_array($package, $this->searchable)){
			$this->searchable[] = $package;
		}
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
		$searchable	= array_merge($this->searchable, array(
			'Solidocs',
			'Application'
		));
		
		if(in_array($package, $searchable)){
			$searchable = array($package);
		}
		
		foreach($searchable as $package){
			$path = PACKAGE . '/' . $package;
			
			if($package == 'Application'){
				$path = APP;
			}
			
			if(file_exists($path.'/'.$file)){
				$slug = str_replace($package . '_' , '', $class);
				
				if(!empty($type)){
					$slug = str_replace($type . '_' , '', $slug);
				}
				
				return array(
					'prefix'	=> $package,
					'path'		=> $path.'/'.$file,
					'class'		=> $package.'_'.$class,
					'slug'		=> strtolower($slug)
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
			if(isset(Solidocs::$registry->model->$search['slug'])){
				return true;
			}
			
			include($search['path']);
			Solidocs::$registry->model->$search['slug'] = new $search['class'];
		}
		else{
			trigger_error('Model "'.$class.'" could not be loaded');
		}
	}
	
	/**
	 * Helper
	 *
	 * @param string
	 * @param string	Optional.
	 */
	public function helper($class, $package = null){
		$search = $this->search($class, 'Helper', $package);
		
		if(is_array($search)){
			if(isset(Solidocs::$registry->helper->$search['slug'])){
				return true;
			}
			
			include($search['path']);
			Solidocs::$registry->helper->$search['slug'] = new $search['class'];
		}
		else{
			trigger_error('Helper "'.$class.'" could not be loaded');
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
		if($this->localized_view == true){
			$search = $this->search($view . '.' . str_replace('_', '-', strtolower($this->locale)), 'View', $package);
		}
		
		if(!isset($search) OR !is_array($search)){
			$search = $this->search($view, 'View', $package);
		}
		
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