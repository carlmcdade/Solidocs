<?php
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
		try{
			// Setup core and plugins
			$this->setup_core();
			$this->setup_plugins();
			
			// Setup libraries
			Solidocs::do_action('pre_libraries');
			$this->setup_libraries();
			Solidocs::do_action('post_libraries');
			
			// Configure
			Solidocs::do_action('pre_config');
			$this->setup_configure();
			Solidocs::do_action('post_config,post_setup');
			
			// Execute
			Solidocs::do_action('pre_execute');
			$this->execute();
			Solidocs::do_action('post_execute');
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
		include(PACKAGE . '/Solidocs/Error.php');
		include(PACKAGE . '/Solidocs/Config.php');
		include(PACKAGE . '/Solidocs/Load.php');
		
		// Default config
		$config = array(APP . '/Config/Application');
		
		// Staging and development config
		if(APPLICATION_ENV == 'staging'){
			$config[] = APP . '/Config/Application.staging';
		}
		elseif(APPLICATION_ENV == 'development'){
			$config[] = APP . '/Config/Application.staging';
			$config[] = APP . '/Config/Application.development';
		}
		else{
			ini_set('display_errors', 0);
		}
		
		// Set up core libraries
		Solidocs::$registry->config	= new Solidocs_Config($config);
		Solidocs::$registry->error	= new Solidocs_Error;
		Solidocs::$registry->load	= new Solidocs_Load;
		Solidocs::apply_config($this->error, $this->config->get('Solidocs_Error'));
		Solidocs::apply_config($this->load, $this->config->get('Solidocs_Load'));
		
		// Setup database
		$this->load->library('Db');
		$this->db->connect();
		$this->db->select_db();
	}
	
	/**
	 * Setup plugins
	 */
	public function setup_plugins(){
		// Hooks
		if($this->config->get('Hooks', false) !== false){
			foreach($this->config->get('Hooks') as $key => $val){
				foreach($val as $hook){
					Solidocs::add_action($key, $hook);	
				}
			}
		}
		
		// Plugins
		if($plugins = $this->config->get('Plugins')){
			foreach($plugins['autoload'] as $class){
				$this->load->plugin($class);
			}
		}
	}
	
	/**
	 * Setup libraries
	 */
	public function setup_libraries(){
		$this->load->library(array(
			'Router',
			'Session',
			'Input',
			'I18n',
			'Output',
			'Theme',
			'Acl',
			'User'
		));
	}
	
	/**
	 * Setup configure
	 */
	public function setup_configure(){
		// Load production routes
		$routes = $this->config->load_file(APP . '/Config/Routes', true);
		
		// Staging routes
		if(APPLICATION_ENV == 'staging' OR APPLICATION_ENV == 'development'){
			if($this->config->file_exists(APP . '/Config/Routes.staging')){
				$routes = array_merge($routes, $this->config->load_file(APP . '/Config/Routes.staging', true));	
			}
		}
		
		// Development routes
		if(APPLICATION_ENV == 'development'){
			if($this->config->file_exists(APP . '/Config/Routes.development')){
				$routes = array_merge($routes, $this->config->load_file(APP . '/Config/Routes.development', true));
			}
		}
		
		// Set routes and view handler
		$this->router->set_routes($routes);
		$this->load->set_view_handler($this->output);
	}
	
	/**
	 * Execute
	 */
	public function execute(){
		$this->router->route();
		$this->output->set_type($this->router->output_type);
		$this->dispatch($this->router->package, $this->router->controller, $this->router->action);
	}
	
	/**
	 * Render
	 */
	public function render(){
		echo Solidocs::apply_filter('render', $this->output->render());
	}
	
	/**
	 * Dispatch
	 *
	 * @param string
	 * @param string
	 * @param string	Optional.
	 */
	public function dispatch($package, $controller, $action = 'index'){
		if(strtolower($package) !== 'application'){
			$this->load->package($package);
		}
		
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
			$this->dispatch('Application', 'Error', '500');
			
			if(APPLICATION_ENV == 'development'){
				die('<pre>' . $e . '</pre>');
			}
		}
	}
}