<?php
class Solidnode_Model_Node extends Solidocs_Base
{
	/**
	 * Get
	 *
	 * @param array
	 * @return array|bool
	 */
	public function get($where){
		$this->db->select_from('node')->where($where)->run();
		
		if(!$this->db->affected_rows()){
			return false;
		}
		
		$node = (object) $this->db->fetch_assoc();
		
		if(is_serialized($node->content)){
			$node->content = unserialize($node->content);
		}
		
		return $node;
	}
}