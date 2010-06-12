<?php
class Solidocs_Ar extends Solidocs_Base
{
	/**
	 * Table
	 */
	public $table;
	
	/**
	 * Identifier
	 */
	public $identifier;
	
	/** 
	 * Row
	 */
	public $row = array();
	
	/**
	 * Id
	 */
	public $id = null;
	
	/**
	 * Constructor
	 */
	public function __construct($table, $identifier, $id = null){
		$this->table = $table;
		$this->identifier = $identifier;
		
		if(!is_null($id)){
			$this->db->select_from($this->table)->where(array(
				$this->identifier => $id
			))->limit(1)->run();
			
			$this->row = $this->db->fetch_assoc();
			$this->id = $id;
			
			unset($this->row[$this->identifier]);
		}
	}
	
	/**
	 * Get
	 *
	 * @param string
	 * @return mixed
	 */
	public function __get($key){
		if(isset($this->row[$key])){
			return $this->row[$key];
		}
		
		return parent::__get($key);
	}
	
	/**
	 * Set
	 *
	 * @param string
	 * @param mixed
	 */
	public function __set($key, $val){
		$this->row[$key] = $val;
	}
	
	/**
	 * Set
	 *
	 * @param array
	 */
	public function set($array){
		$this->row = array_merge($this->row, $array);
	}
	
	/**
	 * Save
	 */
	public function save(){
		if(is_null($this->id)){
			$this->db->insert_into($this->table, $this->row)->run();
			$this->id = $this->db->insert_id();
		}
		else{
			$this->db->update_set($this->table, $this->row)->where(array(
				$this->identifier => $this->id
			))->run();
		}
	}
}