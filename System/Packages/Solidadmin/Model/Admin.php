<?php
class Solidadmin_Model_Admin extends Solidocs_Base
{
	/**
	 * Get item
	 *
	 * @param string
	 * @return array|bool
	 */
	public function get_item($item){
		$this->db->select_from('admin', 'controller')->where(array(
			'item' => $item
		))->run();
		
		if($this->db->affected_rows()){
			return $this->db->fetch_assoc();
		}
		
		return false;
	}
}