<?php
class Solidocs_Db
{
	/**
	 * Server
	 */
	public $server = 'localhost';
	
	/**
	 * User
	 */
	public $user;
	
	/**
	 * Password
	 */
	public $password;
	
	/**
	 * Database
	 */
	public $database;
	
	/**
	 * Charset
	 */
	public $charset;
	
	/**
	 * Driver
	 */
	public $driver = 'Solidocs_Db_Adapter_Mysql';
		
	/**
	 * Instance
	 */
	public $instance;
	
	/**
	 * Call magic method
	 *
	 * @param string
	 * @param array
	 */
	public function __call($method, $params){
		return call_user_func_array(array($this->instance, $method), $params);
	}
	
	/**
	 * Connect
	 *
	 * @param string	Optional.
	 * @param string	Optional.
	 * @param string	Optional.
	 */
	public function connect($server = null, $user = null, $password = null){
		if($server == null){
			$server = $this->server;
		}
		
		if($user == null){
			$user = $this->user;
		}
		
		if($password == null){
			$password = $this->password;
		}
		
		if(!is_object($this->instance)){
			$this->instance = new $this->driver;
		}
		
		if(!$this->instance->connect($this->server, $this->user, $this->password)){
			trigger_error('Could not connect to database server');
		}
	}
	
	/**
	 * Select db
	 *
	 * @param string	Optional.
	 */
	public function select_db($database = null){
		if($database == null){
			$database = $this->database;
		}
		
		if(!$this->instance->select_db($database)){
			trigger_error('Could not select database "' . $database . '"');
		}
	}
}