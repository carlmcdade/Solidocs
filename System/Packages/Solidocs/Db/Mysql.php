<?php
class Solidocs_Db_Mysql
{
	/**
	 * Link
	 */
	public $link;
	
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
}