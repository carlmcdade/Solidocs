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
		$this->setup();
		$this->execute();
		$this->render();
	}
	
	/**
	 * Setup
	 */
	public function setup(){
		Solidocs::do_action('pre_setup');
		
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
		
		Solidocs::do_action('pre_libraries');
		
		// Load libraries
		$this->load->library(array(
			'Router',
			'Session',
			'Input',
			'I18n',
			'Output',
			'Theme',
			'Acl'
		));
		
		Solidocs::do_action('post_libraries');
		
		// Set routes, set view handler and load user model
		$this->router->set_routes($this->config->load_file(APP . '/Config/Routes', true));
		$this->load->set_view_handler(array(
			$this->output, 'add_view'
		));
		$this->load->model('User');
		
		Solidocs::do_action('post_setup,pre_execute');
	}
	
	/**
	 * Execute
	 */
	public function execute(){
		$this->router->route();
		$this->dispatch($this->router->package, $this->router->controller, $this->router->action);
		
		Solidocs::do_action('post_execute,pre_render');
	}
	
	/**
	 * Render
	 */
	public function render(){
		echo Solidocs::apply_filter('render', $this->output->render());
		
		Solidocs::do_action('post_render');
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
}