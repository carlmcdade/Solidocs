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
	 * Localized view
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
	public function set_view_handler(&$view_handler){
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
		
		$file = implode('/', explode('_', $class)) . '.php';
		
		$searchable = array(
			'Application' => APP
		);
		
		foreach($this->searchable as $key){
			$searchable[$key] = PACKAGE . '/' . $key;
		}
		
		$searchable['Solidocs']	= PACKAGE . '/Solidocs';
		$searchable['Package']	= PACKAGE;
				
		if(is_string($package) AND !empty($package)){
			$searchable = array($package => $searchable[$package]);
		}
						
		foreach($searchable as $package => $path){
			if(file_exists($path . '/' . $file)){
				$prefix	= $package;
				$slug	= str_replace($package . '_' , '', $class);
				
				if($package == 'Package'){
					$prefix = '';
				}
				else{
					$class = $package . '_' . $class;
				}
				
				if(!empty($type)){
					$slug = str_replace($type . '_' , '', $slug);
				}
				
				return array(
					'prefix'	=> $prefix,
					'path'		=> $path . '/' . $file,
					'class'		=> $class,
					'slug'		=> strtolower($slug)
				);
			}
		}
		
		return false;
	}
	
	/**
	 * Library
	 *
	 * @param string|array
	 */
	public function library($libraries){
		if(!is_array($libraries)){
			$libraries = explode(',', $libraries);
		}
		
		foreach($libraries as $library){
			$search = $this->search($library);
			
			if(is_array($search)){
				$config = array();
				
				if(is_object($this->config)){
					$config	= $this->config->get($search['class']);
				}
				
				Solidocs::$registry->$search['slug'] = new $search['class']($config);
				
				if(is_array($config)){
					Solidocs::apply_config(Solidocs::$registry->$search['slug'], $config);
				}
			}
			else{
				throw new Exception('The library "' . $library . '" could not be loaded');
			}
		}
	}
	
	/**
	 * Plugin
	 *
	 * @param string
	 * @return object
	 */
	public function plugin($class){
		$search = $this->search($class);
		
		if(is_array($search)){
			if(isset(Solidocs::$registry->plugin->$search['slug'])){
				return Solidocs::$registry->plugin->$search['slug'];
			}
			
			if(!class_exists($search['class'])){
				include_once($search['path']);
			}
			
			Solidocs::$registry->plugin->$search['slug'] = new $search['class'];
			
			return Solidocs::$registry->plugin->$search['slug'];
		}
		else{
			throw new Exception('Plugin "' . $class . '" could not be loaded');
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
			
			include_once($search['path']);
			Solidocs::$registry->model->$search['slug'] = new $search['class'];
		}
		else{
			throw new Exception('Model "' . $class . '" could not be loaded');
		}
	}
	
	/**
	 * Helper
	 *
	 * @param string
	 * @param string	Optional.
	 */
	public function helper($helper, $package = null){
		$class = '';
		
		foreach(explode('_', $helper) as $part){
			$class .= '_' . ucfirst($part);
		}
		
		$search = $this->search(trim($class, '_'), 'Helper', $package);
		
		if(is_array($search)){
			if(isset(Solidocs::$registry->helper->$search['slug'])){
				return true;
			}
			
			include_once($search['path']);
			Solidocs::$registry->helper->$search['slug'] = new $search['class'];
		}
		else{
			throw new Exception('Helper "' . $class . '" could not be loaded');
		}
	}
	
	/**
	 * Controller
	 *
	 * @param string
	 * @param string	Optional.
	 * @return object
	 */
	public function controller($class, $package = null){
		$search = $this->search($class, 'Controller', $package);
		
		if(is_array($search)){
			include_once($search['path']);
			return new $search['class'];
		}
		else{
			throw new Exception('Controller "' . $class . '" could not be loaded');
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
				call_user_func_array(array($this->view_handler, 'add_view'),array(
					$search['path'],
					$params
				));
			}
			else{
				include_once($search['path']);
			}
		}
		else{
			throw new Exception('View "' . $view . '" could not be loaded');
		}
	}
}