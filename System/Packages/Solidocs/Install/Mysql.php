<?php
class Solidocs_Install_Mysql extends Solidocs_Base
{
	/**
	 * Engine
	 */
	public $engine = 'MyISAM';
	
	/**
	 * Tables
	 */
	public $tables = array();
	
	/**
	 * Types
	 */
	public $types = array(
		'string'	=> 'VARCHAR',
		'integer'	=> 'INT',
		'bool'		=> 'TINYINT',
		'text'		=> 'TEXT'
	);
	
	/**
	 * Install
	 */
	public function install(){
		$sql = '';
		
		foreach($this->tables as $table => $fields){
			$sql		.= 'CREATE TABLE IF NOT EXISTS `' . $table . '` (' . "\n";
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
			
			$sql = trim($sql, ',') . ') ENGINE=' . $this->engine . ';' . "\n\n";
		}
		
		debug($sql);
	}
}