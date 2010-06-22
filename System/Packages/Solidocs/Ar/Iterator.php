<?php
class Solidocs_Ar_Iterator implements Iterator
{
	/**
	 * Array
	 */
	public $array;
	
	/**
	 * Position
	 */
	public $position = 0;
	
	/**
	 * Table
	 */
	public $table;
	
	/**
	 * Identifier
	 */
	public $identifier;
	
	/**
	 * Constructor
	 *
	 * @param resource|object
	 */
	public function __construct($table, $identifier, $rows){
		$this->table = $table;
		$this->identifier = $identifier;
		
		if(is_object($rows)){
			$this->array = $rows->arr();
		}
		else{
			$this->array = $rows;
		}
	}
	
	/**
	 * Rewind
	 */
	public function rewind(){
		$this->position = 0;
	}
	
	/**
	 * Current
	 */
	public function current(){
		return new Solidocs_Ar($this->table, $this->identifier, $this->array[$this->position]);
	}
	
	/**
	 * Key
	 */
	public function key(){
		return $this->position;
	}
	
	/**
	 * Next
	 */
	public function next(){
		return ++$this->position;
	}
	
	/**
	 * Valid
	 */
	public function valid(){
		return isset($this->array[$this->position]);
	}
}