<?php
class Solidocs_Application extends Solidocs_Base
{
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
		include(PACKAGE.'/Solidocs/Config.php');
		include(PACKAGE.'/Solidocs/Load.php');
		include(PACKAGE.'/Solidocs/Router.php');
		include(PACKAGE.'/Solidocs/I18n.php');
		
		// Setup core
		Solidocs::$registry->config	= new Solidocs_Config(APP.'/Config/Application.ini');
		Solidocs::$registry->load	= new Solidocs_Load($this->config->get('Solidocs_Load'));
		
		// Setup other classes
		$this->load->library('Solidocs',array(
			'Router',
			'I18n'
		));
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
}