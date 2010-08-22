<?php
/**
 * Admin Model
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Admin
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Admin_Model_Admin extends Solidocs_Base
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
	
	/**
	 * Get items
	 *
	 * @return array
	 */
	public function get_items(){
		$this->db->select_from('admin')->run();
		
		return $this->db->arr();
	}
}