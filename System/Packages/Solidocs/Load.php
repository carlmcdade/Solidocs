<?php
/**
 * Load
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php
 */
class Solidocs_Load extends Solidocs_Base
{
	/**
	 * Packages
	 */
	public $packages = array();
	
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
		
		if(substr($file, 0, 11) == 'Application'){
			include_once(SYS . DIRECTORY_SEPARATOR . $file);
		}
		else{
			include_once(PACKAGE . DIRECTORY_SEPARATOR . $file);
		}
	}
	
	/**
	 * Package
	 *
	 * @param string
	 */
	public function package($package){
		if(!in_array($package, $this->packages)){
			$this->packages[] = $package;
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
		
		$packages = array(
			'Application' => APP
		);
		
		foreach($this->packages as $key){
			$packages[$key] = PACKAGE . '/' . $key;
		}
		
		$packages['Solidocs']	= PACKAGE . '/Solidocs';
		$packages['Package']	= PACKAGE;
				
		if(is_string($package) AND !empty($package)){
			if(!isset($packages[$package])){
				throw new Exception('The specified package is not allowed to be loaded from.');
			}
			else{
				$packages = array($package => $packages[$package]);
			}
		}
						
		foreach($packages as $package => $path){
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
	public function library($library){
		$search = $this->search($library);
			
		if(is_array($search)){
		    if(!isset(Solidocs::$registry->$search['slug'])){
		    	$config = array();
		    	
		    	if(is_object($this->config)){
		    		$config = $this->config->get($library);
		    	}
		    	
		    	Solidocs::$registry->$search['slug'] = new $search['class']($config);
		    	
		    	if(is_array($config)){
		    		Solidocs::apply_config(Solidocs::$registry->$search['slug'], $config);
		    	}
		    }
		}
		else{
		    throw new Exception('The library "' . $library . '" could not be loaded');
		}
	}
	
	/**
	 * Plugin
	 *
	 * @param string
	 * @param array		Optional.
	 * @return object
	 */
	public function plugin($class, $config = array()){
		$search = $this->search($class);
		
		if(is_array($search)){
			if(isset(Solidocs::$registry->plugin->$search['slug'])){
				return Solidocs::$registry->plugin->$search['slug'];
			}
			
			if(!class_exists($search['class'])){
				include_once($search['path']);
			}
			
			$_config = $this->config->get($class);
			
			if(is_array($_config)){
				$config = array_merge($_config, $config);
			}
			
			Solidocs::$registry->plugin->$search['slug'] = new $search['class']($config);
			
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
		
		$class	= trim($class, '_');
		$search	= $this->search($class, 'Helper', $package);
		
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
				call_user_func_array(array($this->view_handler, 'add_view'), array(
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
	
	/**
	 * Libraries
	 *
	 * @param array
	 */
	public function libraries($libraries){
		if(!is_array($libraries)){
			return false;
		}
		
		foreach($libraries as $library){
			$this->library($library);
		}
	}
	
	/**
	 * Models
	 *
	 * @param array
	 */
	public function models($models){
		if(!is_array($models)){
			return false;
		}
		
		foreach($models as $model){
			if(is_array($model) AND isset($model['package'])){
				$this->model($model['model'], $model['package']);
			}
			else{
				$this->model($model);
			}
		}
	}
	
	/**
	 * Get library
	 *
	 * @param string
	 * @return object
	 */
	public function get_library($library){
		$search = $this->search($library);
		
		if(is_array($search)){
			return new $search['class'];
		}
		else{
			throw new Exception('The library "' . $library . '" could not be loaded');
		}
	}
	
	/**
	 * Get model
	 *
	 * @param string
	 * @param string	Optional.
	 */
	public function get_model($class, $package = null){
		$search = $this->search($class, 'Model', $package);
		
		if(is_array($search)){
			if(isset(Solidocs::$registry->model->$search['slug'])){
				return true;
			}
			
			include_once($search['path']);
			return new $search['class'];
		}
		else{
			throw new Exception('Model "' . $class . '" could not be loaded');
		}
	}
	
	/**
	 * Get view
	 *
	 * @param string
	 * @param array		Optional.
	 * @param string	Optional.
	 * @return string
	 */
	public function get_view($view, $params = null, $package = null){
		if($this->localized_view == true){
			$search = $this->search($view . '.' . str_replace('_', '-', strtolower($this->locale)), 'View', $package);
		}
		
		if(!isset($search) OR !is_array($search)){
			$search = $this->search($view, 'View', $package);
		}
		
		if(is_array($search)){
			if(isset($this->view_handler)){
				return call_user_func_array(array($this->view_handler, 'render_view'), array(
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