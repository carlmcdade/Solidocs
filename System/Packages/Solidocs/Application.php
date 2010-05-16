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
		// Include classes
		include(PACKAGE . '/Solidocs/Config.php');
		include(PACKAGE . '/Solidocs/Load.php');
		
		// Setup core
		Solidocs::$registry->config	= new Solidocs_Config(APP . '/Config/Application.ini');
		Solidocs::$registry->load	= new Solidocs_Load($this->config->get('Solidocs_Load'));
		
		// Setup other classes
		$this->load->library('Solidocs',array(
			'Router',
			'I18n',
			'Output'
		));
		
		// Set routes
		$this->router->set_routes($this->config->load_file(APP . '/Config/Routes.ini', true));
		
		// Set view handler
		$this->load->set_view_handler(array(
			$this->output,'add_view'
		));
	}
	
	/**
	 * Execute
	 */
	public function execute(){
		$this->router->route();
		$this->dispatch($this->router->package,$this->router->controller,$this->router->action);
	}
	
	/**
	 * Render
	 */
	public function render(){
		$this->output->render();
	}
	
	/**
	 * Dispatch
	 *
	 * @param string
	 * @param string
	 * @param string	Optional.
	 */
	public function dispatch($package,$controller,$action = 'index'){
		$class = $this->load->controller($controller,$package);
		
		if(!empty($class)){
			$this->controller = new $class;
			$this->controller->dispatch_action($action);
		}
	}
}