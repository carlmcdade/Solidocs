<?php
class Solidocs_Plugin_Db extends Solidocs_Plugin
{
	/**
	 * Name
	 */
	public $name = 'Solidocs Database Plugin';
	
	/**
	 * Description
	 */
	public $description = 'A plugin which enables configuration loading from the database';
	
	/**
	 * Config
	 */
	public function config(){
		$this->db->select()->from('config')->run();
		
		if($this->db->affected_rows() !== 0){
			$array = array();
			
			foreach($this->db->arr() as $item){
				$array[$item['key']] = $item['value'];
			}
			
			$this->config->add_array($array);
		}
	}
}