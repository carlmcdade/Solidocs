<?php
class Solidocs_Db_Mysql
{
	/**
	 * Link
	 */
	public $link;
	
	/**
	 * Result
	 */
	public $result;
	
	/**
	 * Connect
	 *
	 * @param string
	 * @param string
	 * @param string
	 */
	public function connect($server, $user, $password){
		return ($this->link = mysql_connect($server, $user, $password));
	}
	
	/**
	 * Select db
	 *
	 * @param string
	 */
	public function select_db($database){
		return (mysql_select_db($database, $this->link));
	}
	
	/**
	 * Query
	 *
	 * @param string	$query
	 */
	public function query($query){
		$this->result = mysql_query($query);
	}
	
	/**
	 * Fetch assoc
	 */
	public function fetch_assoc(){
		return mysql_fetch_assoc($this->result);
	}
	
	/**
	 * Fetch row
	 */
	public function fetch_row(){
		return mysql_fetch_row($this->result);
	}
}