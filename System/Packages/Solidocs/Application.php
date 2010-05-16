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
		include(PACKAGE.'/Solidocs/Config.php');
		include(PACKAGE.'/Solidocs/Load.php');
		
		Solidocs::$registry->config	= new Solidocs_Config(APP.'/Config/Application.ini');
		Solidocs::$registry->load	= new Solidocs_Load;
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