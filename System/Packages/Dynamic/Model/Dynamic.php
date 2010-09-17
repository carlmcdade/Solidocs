<?php
class Dynamic_Model_Dynamic extends Solidocs_Base
{
	/**
	 * Set config
	 *
	 * @param string
	 * @param mixed
	 */
	public function set_config($key, $val){
		$this->db->select_from('config', 'key')->where(array(
			'key' => $key
		))->run();
		
		if($this->db->affected_rows()){
			$this->db->update_set('config', array(
				'value'	=> $val
			))->where(array(
				'key'	=> $key
			))->run();
		}
		else{
			$this->db->insert_into('config', array(
				'key' 	=> $key,
				'value'	=> $val
			))->run();
		}
	}
}