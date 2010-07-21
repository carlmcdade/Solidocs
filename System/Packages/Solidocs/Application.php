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
			// Setup
			$this->setup_core();
			$this->setup_plugins();
			$this->setup_libs();
			$this->setup_config();
			
			Solidocs::do_action('post_setup');
			
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
		
		// Setup core
		Solidocs::$registry->config	= new Solidocs_Config(array(APP . '/Config/Application', APP . '/Config/Libraries'));
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
		if($this->config->get('Hooks') !== false){
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
	 * Setup libs
	 */
	public function setup_libs(){
		Solidocs::do_action('pre_libraries');
		
		// Load libraries
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
		
		Solidocs::do_action('post_libraries');
	}
	
	/**
	 * Setup config
	 */
	public function setup_config(){
		Solidocs::do_action('pre_config');
		
		// Set routes, set view handler and load user model
		$this->router->set_routes($this->config->load_file(APP . '/Config/Routes', true));
		$this->load->set_view_handler($this->output);
		
		Solidocs::do_action('post_config');
	}
	
	/**
	 * Execute
	 */
	public function execute(){
		$this->router->route();
		$this->dispatch($this->router->package, $this->router->controller, $this->router->action);
		$this->output->set_type($this->router->output_type);
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
		
		$class = $this->load->controller($controller, $package);
		
		if(!empty($class)){
			$this->controller = new $class;
			$this->controller->dispatch_action($action);
		}
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
				die($e);
			}
		}
	}
}