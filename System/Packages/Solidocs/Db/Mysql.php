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
	 * Queries
	 */
	public $queries = array();
	
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
		
		if($this->affected_rows < 0){
			$this->affected_rows = 0;
		}
		
		$this->queries = array(
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
	public function select($fields = '*'){
		$this->query .= 'SELECT ' . $fields . ' ';
		
		return $this;
	}
	
	/**
	 * Delete
	 *
	 * @return object
	 */
	public function delete(){
		$this->query .= 'DELETE ';
	}
	
	/**
	 * From
	 *
	 * @param string
	 * @return object
	 */
	public function from($table){
		$this->query .= 'FROM ' . $table . ' ';
		
		return $this;
	}
	
	/**
	 * Insert into
	 *
	 * @param string
	 * @param array
	 * @return object
	 */
	public function insert_into($table,$data){
		$this->query .= 'INSERT INTO ' . $table . ' (' . implode(',', array_keys($data)) . ') VALUES("' . implode('","', $data) . '")';
		
		return $this;
	}
	
	/**
	 * Update set
	 *
	 * @param string
	 * @param array
	 * @return object
	 */
	public function update_set($table,$data){
		$this->query .= 'UPDATE ' . $table . ' SET ';
		
		foreach($data as $key=>$val){
			$this->query .= $key . ' = "' . $val . '", ';
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
		$this->query .= 'JOIN ' . $table . ' ON(' . $on1 . ' = ' . $on2 . ') ';
		
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
		$this->query .= 'ORDER BY ' . $order_by . ' ' . $order . ' ';
		
		return $this;
	}
	
	/**
	 * Limit
	 *
	 * @param integer
	 * @return object
	 */
	public function limit($limit){
		$this->query .= 'LIMIT ' . $limit;
		
		return $this;
	}
	
	/**
	 * Where
	 *
	 * @param array
	 * @return object
	 */
	public function where($args){
		$this->query .= 'WHERE ';
		
		foreach($args as $key => $val){
			$this->query .= $key . ' = "' . $val . '" AND ';
		}
		
		$this->query = trim($this->query, ' AND ') . ' ';
		
		return $this;
	}
	
	/**
	 * Where in
	 *
	 * @param string
	 * @param array
	 * @return object
	 */
	public function where_in($field, $args){
		$this->query .= 'WHERE IN(' . implode(',', $args) . ') ';
		
		return $this;
	}
}