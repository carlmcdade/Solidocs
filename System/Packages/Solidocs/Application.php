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
		include(PACKAGE . '/Solidocs/Router.php');
		include(PACKAGE . '/Solidocs/I18n.php');
		
		// Setup core
		Solidocs::$registry->config	= new Solidocs_Config(APP . '/Config/Application.ini');
		Solidocs::$registry->load	= new Solidocs_Load($this->config->get('Solidocs_Load'));
		
		// Setup other classes
		$this->load->library('Solidocs',array(
			'Router',
			'I18n'
		));
		
		// Set routes
		$this->router->set_routes($this->config->load_file(APP . '/Config/Routes.ini', true));
	}
	
	/**
	 * Execute
	 */
	public function execute(){
	
	}
	
	/**
	 * Render
	 */
	public function render(){
	
	}
	
	/**
	 * Dispatch
	 *
	 * @param string
	 * @param string
	 * @param string	Optional.
	 */
	public function dispatch($package,$controller,$action = 'index'){
		$search = $this->load->controller($controller,$package);
		
		if(is_array($search)){
			$this->controller = new $search['class'];
			$this->controller->dispatch_action($action);
		}
	}
}