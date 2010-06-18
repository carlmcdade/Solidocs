<?php
class Solidocs_Install extends Solidocs_Base
{	
	/**
	 * Tables
	 */
	public $tables;
	
	/**
	 * Data
	 */
	public $data;
	
	/**
	 * Engine
	 */
	public $engine = 'MyISAM';
	
	/**
	 * Field
	 */
	public $types = array(
		'string' => 'VARCHAR',
		'bool' => 'TINYINT',
		'int' => 'INTEGER',
		'text' => 'TEXT'
	);
	
	/**
	 * Get tables
	 *
	 * @return array
	 */
	public function get_tables(){
		return array_keys($this->tables);
	}

	/**
	 * Install
	 */
	public function install(){
		foreach($this->tables as $table => $fields){
			$sql		= 'CREATE TABLE IF NOT EXISTS `' . $table . '` (' . "\n";
			$indexes	= array();
			
			foreach($fields as $name => $field){
				$sql .= '`' . $name . '` ' . $this->types[$field['type']];
				
				if($field['type'] == 'bool'){
					$field['length'] = 1;
				}
				
				if(isset($field['length'])){
					$sql .= '( ' . $field['length'] . ' )';
				}
				
				$sql .= ' NOT NULL ';
				
				if(isset($field['auto_inc'])){
					$sql .= 'AUTO_INCREMENT ';
				}
				
				if(isset($field['primary'])){
					$sql .= 'PRIMARY KEY ';
				}
				
				if(isset($field['default'])){
					if($field['default'] == false){
						$field['default'] = 0;
					}
					
					$sql .= 'DEFAULT \'' . $field['default'] . '\'';
				}
				
				if(isset($field['index'])){
					$indexes[] = 'INDEX ( `' . $name . '` ) ';
				}
				
				if(isset($field['unique'])){
					$indexes[] = 'UNIQUE ( `' . $name . '` ) ';
				}
				
				$sql .= ',' . "\n";
			}
			
			if(count($indexes) !== 0){
				$sql .= implode(',' . "\n", $indexes) . "\n";
			}
			
			$this->db->sql(trim($sql, ',') . ') ENGINE=' . $this->engine . ';')->run();
		}
		
		if(count($this->data) !== 0){
			foreach($this->data as $table => $item){
				$this->db->insert_into($table, $item)->run();
			}
		}
	}
	
	/**
	 * Uninstall
	 */
	public function uninstall(){
		foreach($this->tables as $table => $fields){
			$this->db->sql('DROP TABLE IF EXISTS `' . $table . '`;')->run();
		}
	}
}