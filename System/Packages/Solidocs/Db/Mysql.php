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
	 * First having
	 */
	public $first_having = true;
	
	/**
	 * Queries
	 */
	public $queries = array();
	
	/**
	 * Last query
	 */
	public $last_query;
	
	/**
	 * Connect
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @return bool
	 */
	public function connect($server, $user, $password){
		return ($this->link = mysql_connect($server, $user, $password));
	}
	
	/**
	 * Select db
	 *
	 * @param string
	 * @return bool
	 */
	public function select_db($database){
		return (mysql_select_db($database, $this->link));
	}
	
	/**
	 * Query
	 *
	 * @param string	$query
	 * @return bool
	 */
	public function query($query){
		if(!$this->result = mysql_query($query)){
			trigger_error(mysql_error($this->link));
			return false;
		}
		
		return true;
	}
	
	/**
	 * Run
	 *
	 * @return object
	 */
	public function run(){
		$success				= $this->query($this->query);
		$this->affected_rows	= mysql_affected_rows($this->link);
		$this->insert_id		= mysql_insert_id($this->link);
		$this->first_order		= true;
		$this->first_where		= true;
		$this->last_query		= $this->query;
		
		if($this->affected_rows < 0){
			$this->affected_rows = 0;
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
		$this->query .= 'SELECT ' . $fields . ' FROM ' . $this->_table($table) . ' ';
		
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
	 * @return object
	 */
	public function insert_into($table, $data){
		$this->query .= 'INSERT INTO ' . $this->_table($table) . ' (`' . implode('`,`', array_keys($data)) . '`) VALUES("' . implode('","', $data) . '")';
		
		return $this;
	}
	
	/**
	 * Update set
	 *
	 * @param string
	 * @param array
	 * @return object
	 */
	public function update_set($table, $data){
		$this->query .= 'UPDATE ' . $this->_table($table) . ' SET ';
		
		foreach($data as $key=>$val){
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
		
		$this->query .= $order_by . ' ' . $order . ' ';
		
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
		$this->query .= 'LIMIT ' . $offset . ',' . $limit . ' ';
		
		return $this;
	}
	
	/**
	 * Offset
	 *
	 * @param integer
	 * @return object
	 */
	public function offset($offset){
		$this->query .= 'OFFSET ' . $offset . ' ';
		
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
	 * First having
	 *
	 * @param string
	 */
	public function first_having($separator = 'AND'){
		if($this->first_having){
			$this->query .= 'HAVING ';
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
	public function where($args, $separator = 'AND', $block_separator = 'AND', $having = false){
		if($having){
			$this->first_having($separator);
		}
		else{
			$this->first_where($separator);
		}
		
		foreach($args as $key => $val){
			$comparison = '=';
			
			if(is_array($val)){
				$this->query .= '(';
				
				foreach($val as $key => $val){
					if(substr($val, 0, 5) == 'LIKE '){
						$comparison = 'LIKE';
						$val		= substr($val, 5);
					}
					
					$this->query .= $key . ' ' . $comparison . ' "' . $val . '" ' . $block_separator . ' ';
				}
				
				$this->query = trim($this->query,' ' . $block_separator . ' ') . ') ' . $separator . ' ';
			}
			else{
				if(substr($val, 0, 5) == 'LIKE '){
					$comparison = 'LIKE';
					$val		= substr($val, 5);
				}
				
				$this->query .= $key . ' ' . $comparison . ' "' . $val . '" ' . $separator . ' ';
			}
		}
		
		$this->query = trim($this->query, ' ' . $separator . ' ') . ' ';
		
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
	 * @return object
	 */
	public function where_in($field, $args, $in = 'IN'){
		if($having){
			$this->first_having($separator);
		}
		else{
			$this->first_where($separator);
		}
	
		$this->query .= ' ' . $in . '(' . implode(',', $args) . ') ';
		
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
	 * Having
	 *
	 * @param array
	 * @param string	Optional.
	 * @param string	Optional.
	 * @return object
	 */
	public function having($args, $separator = 'AND', $block_separator = 'AND'){
		return $this->where($args, $separator, $block_separator, true);
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
}