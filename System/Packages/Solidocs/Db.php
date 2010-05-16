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
	public $driver = 'Mysql';
	
	/**
	 * Instance
	 */
	public $instance;
	
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
			$driver_class = 'Solidocs_Db_' . $this->driver;
			$this->instance = new $driver_class;
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