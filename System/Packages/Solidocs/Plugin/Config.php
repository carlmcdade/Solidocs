<?php
class Solidocs_Plugin_Config extends Solidocs_Plugin
{
	/**
	 * Name
	 */
	public $name = 'Solidocs Database Config Plugin';
	
	/**
	 * Description
	 */
	public $description = 'A plugin which enables configuration loading from the database';
	
	/**
	 * Config
	 */
	public function config(){
		$this->db->select_from('config')->run();
		
		if($this->db->affected_rows() !== 0){
			$array = array();
			
			foreach($this->db->arr() as $item){
				$array[$item['key']] = $item['value'];
			}
			
			$this->config->add_array($array);
		}
	}
	
	/**
	 * Set
	 *
	 * @param string
	 * @param mixed
	 */
	public function set($key, $val){
		$this->db->update_set('config', array(
			'val'	=> $val
		))->where(array(
			'key'	=> $key
		))->run();
		
		if($this->db->affected_rows() == 0){
			$this->db->insert_into('config', array(
				'key'	=> $key,
				'val'	=> $val
			))->run();
		}
	}
	
	/**
	 * Delete
	 *
	 * @param string
	 */
	public function delete($key){
		$this->db->delete_from('config')->where(array(
			'key'	=> $key
		))->run();
	}
}