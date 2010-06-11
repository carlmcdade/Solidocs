<?php
class Solidocs_Install extends Solidocs_Base
{
	/**
	 * Instance
	 */
	public $instance;
	
	/**
	 * Adapter
	 */
	public $adapter = 'Solidocs_Install_Mysql';
	
	/**
	 * Tables
	 */
	public $tables;
	
	/**
	 * Init
	 */
	public function init(){
		$this->instance = new $this->adapter;
		$this->instance->tables = $this->tables;
	}
	
	/**
	 * Install
	 */
	public function install(){
		$this->instance->install();
	}
}