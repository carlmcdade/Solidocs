<?php
/**
 * Database
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
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
	 * Link
	 */
	public $link;
	
	/**
	 * Result
	 */
	public $result;
	
	/**
	 * Query
	 */
	public $query = '';
	
	/**
	 * Affected rows
	 */
	public $affected_rows = 0;
	
	/**
	 * Insert id
	 */
	public $insert_id = 0;

	/**
	 * First order
	 */
	public $first_order = true;
	
	/**
	 * First where
	 */
	public $first_where = true;
	
	/**
	 * Queries
	 */
	public $queries = array();
	
	/**
	 * Last query
	 */
	public $last_query;
	
	/**
	 * Last success
	 */
	public $last_success = false;
	
	/**
	 * Connect
	 *
	 * @param string	Optional.
	 * @param string	Optional.
	 * @param string	Optional.
	 * @return bool
	 */
	public function connect($server = '', $user = '', $password = ''){
		if(empty($server)){
			$server = $this->server;
		}
		
		if(empty($user)){
			$user = $this->user;
		}
		
		if(empty($password)){
			$password = $this->password;
		}
		
		$this->link = mysql_connect($server, $user, $password);
		
		if(!is_resource($this->link)){
			throw new Exception('Could not connect to "' . $server . '"');
		}
	}
	
	/**
	 * Select db
	 *
	 * @param string
	 * @return bool
	 */
	public function select_db($database = ''){
		if(empty($database)){
			$database = $this->database;
		}
		
		if(!mysql_select_db($database, $this->link)){
			throw new Exception(mysql_error());
		}
	}
	
	/**
	 * Query
	 *
	 * @param string	$query
	 * @return bool
	 */
	public function query($query){
		if(!$this->result = mysql_query($query)){
			throw new Exception(mysql_error($this->link) . '<br /><b>Query: </b>' . $query . '<br />');
			return false;
		}
		
		return true;
	}
	
	/**
	 * Escape
	 *
	 * @param string|array
	 * @return string|array
	 */
	public function escape($input){
		if(is_array($input)){
			$output = array();
			
			foreach($input as $key => $val){
				if(is_array($val)){
					$output[$key] = $this->escape($val);
				}
				else{
					$output[$key] = mysql_real_escape_string($val, $this->link);
				}
			}
			
			return $output;
		}
		
		return mysql_real_escape_string($input);
	}
	
	/**
	 * Run
	 *
	 * @return object
	 */
	public function run(){
		$this->last_success		= $this->query($this->query);
		$this->affected_rows	= mysql_affected_rows($this->link);
		$this->insert_id		= mysql_insert_id($this->link);
		$this->first_order		= true;
		$this->first_where		= true;
		$this->last_query		= $this->query;
		
		if($this->affected_rows < 0){
			$this->affected_rows = 0;
		}
		
		if(!$this->last_success){
			$success = 'no';
		}
		else{
			$success = 'yes';
		}
		
		$this->queries[] = array(
			'query'		=> $this->query,
			'success'	=> $success,
			'rows'		=> $this->affected_rows
		);
		
		$this->query = '';
		
		return $this;
	}
	
	/**
	 * Is success
	 *
	 * @return bool
	 */
	public function is_success(){
		return $this->last_success;
	}
	
	/**
	 * Fetch assoc
	 *
	 * @return array
	 */
	public function fetch_assoc(){
		return mysql_fetch_assoc($this->result);
	}
	
	/**
	 * Fetch row
	 *
	 * @return array
	 */
	public function fetch_row(){
		return mysql_fetch_row($this->result);
	}
	
	/**
	 * One
	 *
	 * @return mixed
	 */
	public function one(){
		$row = $this->fetch_row();
		return $row[0];
	}
	
	/**
	 * Arr
	 *
	 * @param string
	 * @param bool		Optional.
	 * @return array
	 */
	public function arr($key = '', $unset = false){
		$arr = array();
		
		while($item = $this->fetch_assoc()){
			if(is_numeric($key)){
				if(!isset($i)){
					$i = $key;
				}
				
				$arr[$i] = $item;
				
				$i++;
			}
			elseif(!empty($key)){
				$arr[$item[$key]] = $item;
				
				if($unset){
					unset($arr[$item[$key]][$key]);
				}
			}
			else{
				$arr[] = $item;
			}
		}
		
		return $arr;
	}
		
	/**
	 * Affected rows
	 *
	 * @return integer
	 */
	public function affected_rows(){
		return $this->affected_rows;
	}
	
	/**
	 * Insert id
	 *
	 * @return integer
	 */
	public function insert_id(){
		return $this->insert_id;
	}
	
	/**
	 * Sql
	 *
	 * @param string
	 * @return object
	 */
	public function sql($sql){
		$this->query .= $sql . ' ';
				
		return $this;
	}
	
	/**
	 * Select
	 *
	 * @param string	Optional.
	 * @return object
	 */
	public function select_from($table, $fields = '*'){
		$this->query .= 'SELECT ' . $this->_fields($fields) . ' FROM ' . $this->_table($table) . ' ';
		
		return $this;
	}
	
	/**
	 * Delete
	 *
	 * @return object
	 */
	public function delete_from($table){
		$this->query .= 'DELETE FROM ' . $this->_table($table) . ' ';
		
		return $this;
	}
	
	/**
	 * Insert into
	 *
	 * @param string
	 * @param array
	 * @param bool		Optional.
	 * @return object
	 */
	public function insert_into($table, $data, $escape = true){
		if($escape){
			foreach($data as $key => $val){
				$data[$key] = $this->escape($val);
			}
		}
		
		$this->query .= 'INSERT INTO ' . $this->_table($table) . ' (`' . implode('`,`', array_keys($data)) . '`) VALUES("' . implode('","', $data) . '")';
		
		return $this;
	}
	
	/**
	 * Update set
	 *
	 * @param string
	 * @param array
	 * @param bool		Optional.
	 * @return object
	 */
	public function update_set($table, $data, $escape = true){
		$this->query .= 'UPDATE ' . $this->_table($table) . ' SET ';
		
		foreach($data as $key => $val){
			if($escape){
				$val = $this->escape($val);
			}
			
			$this->query .= '`' . $key . '` = "' . $val . '", ';
		}
		
		$this->query = trim($this->query, ', ') . ' ';
		
		return $this;
	}
	
	/**
	 * Join
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @return object
	 */
	public function join($table, $on1, $on2){
		$this->query .= 'JOIN ' . $this->_table($table) . ' ON(' . $on1 . ' = ' . $on2 . ') ';
		
		return $this;
	}
	
	/**
	 * Order
	 *
	 * @param string
	 * @param string	Optional.
	 * @return object
	 */
	public function order($order_by, $order = 'ASC'){
		$this->first_order();
		
		$this->query .= $this->_fields($order_by) . ' ' . $order . ' ';
		
		return $this;
	}
	
	/**
	 * Limit
	 *
	 * @param integer
	 * @param integer	Optional.
	 * @return object
	 */
	public function limit($limit, $offset = 0){
		$this->query .= 'LIMIT ' . (int) $offset . ',' . (int) $limit . ' ';
		
		return $this;
	}
	
	/**
	 * Offset
	 *
	 * @param integer
	 * @return object
	 */
	public function offset($offset){
		$this->query .= 'OFFSET ' . (int) $offset . ' ';
		
		return $this;
	}
	
	/**
	 * Group by
	 *
	 * @param string
	 * @return object
	 */
	public function group_by($field){
		$this->query .= 'GROUP BY ' . $field . ' ';
		
		return $this;
	}
	
	/**
	 * First order
	 */
	public function first_order(){
		if($this->first_order){
			$this->query .= 'ORDER BY ';
		}
		else{
			$this->query = trim($this->query) . ', ';
		}
		
		$this->first_order = false;
	}
	
	/**
	 * First where
	 *
	 * @param string
	 */
	public function first_where($separator = 'AND'){
		if($this->first_where){	
			$this->query .= 'WHERE ';
		}
		else{
			$this->query .= $separator . ' ';
		}
		
		$this->first_where = false;
	}
	
	/**
	 * Where
	 *
	 * @param array
	 * @param string	Optional.
	 * @param string	Optional.
	 * @param bool		Optional.
	 * @return object
	 */
	public function where($args, $separator = 'AND', $block_separator = 'AND', $is_block = false){
		if(!$is_block){
			$this->first_where($separator);
		}
		
		$last_is_array = false;
		
		foreach($args as $key => $val){
			$val = $this->escape($val);
			
			if(is_array($val)){
				$last_is_array = true;
				
				$this->query .= '(';
				
				foreach($val as $block_val){
					$this->query .= $this->_fields($key) . ' ' . $this->_comparison_val($block_val) . ' ' . $block_separator . ' ';
				}
				
				$this->query = substr($this->query, 0, strlen($this->query) - strlen($block_separator) - 1);
				
				$this->query .= ')';
			}
			else{
				$last_is_array = false;
				
				$this->query .= $this->_fields($key) . ' ' . $this->_comparison_val($val) . ' ' . $separator . ' ';
			}
		}
		
		if(!$last_is_array){
			$this->query = substr($this->query, 0, strlen($this->query) - strlen($separator) - 1);
		}
		
		return $this;
	}
	
	/**
	 * Where or
	 *
	 * @param array
	 * @param string	Optional.
	 * @return object
	 */
	public function where_or($args, $block_separator = 'AND'){
		return $this->where($args, 'OR', $block_separator);
	}
	
	/**
	 * Where in
	 *
	 * @param string
	 * @param array
	 * @param string
	 * @return object
	 */
	public function where_in($field, $args, $separator = 'AND'){
		foreach($args as $key => $val){
			$args[$key] = $this->escape($val);
		}
		
		$this->first_where($separator);
		
		$this->query .= ' ' . $field . ' IN ("' . implode('","', $args) . '") ';
		
		return $this;
	}
	
	/**
	 * Where not in
	 *
	 * @param string
	 * @param array
	 * @return object
	 */
	public function where_not_in($field, $args){
		return $this->where_in($field, $args, 'NOT IN');
	}
	
	/**
	 * Comparison val
	 *
	 * @param string
	 */
	public function _comparison_val($val){
		$comparison = '=';
		
		if(substr($val, 0, 4) == 'LIKE'){
			$comparison = 'LIKE';
			$val		= substr($val, 5);
		}
		
		return $comparison . ' "' . $val . '"';
	}
	
	/**
	 * Table
	 *
	 * @param string
	 * @return string
	 */
	public function _table($table){
		if(!strpos($table, '.')){
			return '`' . $table . '`';
		}
		
		return $table;
	}
	
	/**
	 * Fields
	 *
	 * @param string|array
	 * @return string
	 */
	public function _fields($fields){
		if($fields == '*' OR empty($fields)){
			return '*';
		}
		
		if(!is_array($fields)){
			$fields = explode(',', $fields);
		}
		
		if(!strpos(implode('', $fields), '.')){
			foreach($fields as $key => $val){
				$fields[$key] = '`' . $val . '`';
			}
		}
		
		return implode(',', $fields);
	}
	
	/**
	 * Get tables
	 *
	 * @return array
	 */
	public function get_tables(){
		$this->sql('SHOW TABLES IN `' . $this->database . '`')->run();
		
		$tables = array();
		
		while($item = $this->fetch_assoc()){
			$tables[] = $item['Tables_in_' . $this->database];
		}
		
		return $tables;
	}
}