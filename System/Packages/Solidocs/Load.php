<?php
class Solidocs_Load
{
	/**
	 * Init
	 */
	public function init(){
		spl_autoload_register(array($this, 'autoload'));
	}
	
	/**
	 * Autoload
	 *
	 * @param string
	 */
	public function autoload($class){
		$path = PACKAGE . '/' . implode('/', explode('_', $class));
		
		include($path);
	}
	
	/**
	 * Model
	 *
	 * @param string
	 */
	public function model($class){
	
	}
	
	/**
	 * Controller
	 *
	 * @param string
	 */
	public function controller($class){
	
	}
	
	/**
	 * View
	 *
	 * @param string
	 * @param array		Optional.
	 */
	public function view($view, $params = null){
	
	}
}