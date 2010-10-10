<?php
/**
 * Application
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php
 */
class Solidocs_Application extends Solidocs_Base
{
	/**
	 * Controller
	 */
	public $controller;
	
	/**
	 * Init
	 */
	public function init(){
		// Error handler
		set_error_handler(array($this, 'error_handler'));
		
		try{
			// Setup core, database, plugins and router
			$this->setup_core();
			$this->setup_database();
			$this->setup_plugins();
			$this->setup_router();
			
			// Setup libraries
			Solidocs::do_action('pre_libraries');
			$this->setup_libraries();
			Solidocs::do_action('post_libraries');
			
			// Setup models
			Solidocs::do_action('pre_models');
			$this->setup_models();
			Solidocs::do_action('post_models');
			
			// Check in cache
			if(isset($this->cache) AND $this->cache->exists($this->router->request_uri)){
				$this->render($this->cache->get($this->router->request_uri));
			}
			else{
				// Configure
				Solidocs::do_action('pre_configure');
				$this->setup_configure();
				Solidocs::do_action('post_configure,post_setup');
				
				// Execute
				Solidocs::do_action('pre_execute');
				$this->execute();
				Solidocs::do_action('post_execute');
			}
		}
		catch(Exception $e){
			$this->dispatch_exception($e);
		}
		
		try{
			// Render
			Solidocs::do_action('pre_render');
			$this->render();
			Solidocs::do_action('post_render');
		}
		catch(Exception $e){
			ob_clean();
			$this->dispatch_exception($e);
		}
	}
	
	/**
	 * Setup core
	 */
	public function setup_core(){
		// Include core
		include(PACKAGE . '/Solidocs/Config.php');
		include(PACKAGE . '/Solidocs/Load.php');
		
		// Default config
		$config = array(APP . '/Config/Application');
		
		// Development config
		if(APPLICATION_ENV == 'development' AND file_exists(APP . '/Config/Application.development.ini')){
			$config[] = APP . '/Config/Application.development';
		}
		else{
			ini_set('display_errors', 0);
		}
		
		// Set up core libraries
		Solidocs::$registry->config	= new Solidocs_Config($config);
		Solidocs::$registry->load	= new Solidocs_Load;
		Solidocs::apply_config($this->load,	$this->config->get('Load'));
	}
	
	/**
	 * Setup db
	 */
	public function setup_database(){
		$this->load->library('Db');
		$this->db->connect();
		$this->db->select_db();
		
		$this->db->sql('SET NAMES utf8')->run();
	}
	
	/**
	 * Setup plugins
	 */
	public function setup_plugins(){
		if($plugins = $this->config->get('Autoload.plugins')){
			foreach($plugins as $class){
				$this->load->plugin($class);
			}
		}
	}
	
	/**
	 * Setup router
	 */
	public function setup_router(){
		$this->load->library('Router');
		
		// Load production routes
		$routes = $this->config->load_file(APP . '/Config/Routes', true);
		
		// Development routes
		if(APPLICATION_ENV == 'development' AND $this->config->file_exists(APP . '/Config/Routes.development')){
			$routes = array_merge($routes, $this->config->load_file(APP . '/Config/Routes.development', true));
		}
		
		// Set routes
		$this->router->set_routes($routes);
	}
	
	/**
	 * Setup libraries
	 */
	public function setup_libraries(){
		$this->load->libraries($this->config->get('Autoload.libraries'));
	}
	
	/**
	 * Setup models
	 */
	public function setup_models(){
		$this->load->models($this->config->get('Autoload.models'));
	}
	
	/**
	 * Setup configure
	 */
	public function setup_configure(){
		// Set view handler
		$this->load->set_view_handler($this->output);
	}
	
	/**
	 * Execute
	 */
	public function execute(){
		// Route, set output type and dispatch
		$this->router->route();
		$this->output->set_type($this->router->output_type);
		$this->dispatch($this->router->package, $this->router->controller, $this->router->action);
	}
	
	/**
	 * Render
	 *
	 * @param string	Optional.
	 */
	public function render($output = ''){
		// Retrieve output if it wasn't given
		if(empty($output)){
			$output = $this->output->render();
			
			// Cache output
			if(isset($this->cache) AND $this->cache->cache_page()){
				$this->cache->store($this->router->request_uri, $output);		
			}
		}
		
		// Display and apply filter
		echo Solidocs::apply_filter('render', $output);
	}
	
	/**
	 * Dispatch
	 *
	 * @param string
	 * @param string
	 * @param string	Optional.
	 */
	public function dispatch($package, $controller, $action = 'index'){
		// Load package if the package isn't "application"
		if(strtolower($package) !== 'application'){
			$this->load->package($package);
		}
		
		// Load controller and dispatch
		$this->controller = $this->load->controller($controller, $package);
		$this->controller->dispatch_action($action);
	}
	
	/**
	 * Dispatch exception
	 *
	 * @param object
	 */
	public function dispatch_exception($e){
		// Error
		if($e->getCode() == '404'){
			$this->dispatch('Application', 'Error', '404');
		}
		else{
			if(APPLICATION_ENV == 'development'){
				die('<pre>' . $e . '</pre>');
			}
			
			$this->dispatch('Application', 'Error', '500');
		}
	}
	
	/**
	 * Error handler
	 *
	 * @param integer
	 * @param string
	 * @param string
	 * @param integer
	 */
	public function error_handler($errno, $string, $file, $line){
		$string	= str_replace(ROOT, '', strip_tags($string));
		$file	= str_replace(ROOT, '', $file);
		
		Solidocs::$registry->errors[] = array(
			'errno'		=> $errno,
			'string'	=> $string,
			'file'		=> $file,
			'line'		=> $line
		);
	}
}