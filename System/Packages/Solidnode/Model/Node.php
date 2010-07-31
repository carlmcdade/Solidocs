<?php
class Solidnode_Model_Node extends Solidocs_Base
{
	/**
	 * Get node
	 *
	 * @param array
	 * @return array|bool
	 */
	public function get_node($where){
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
	
	/**
	 * Get nodes
	 *
	 * @param array	Optional.
	 */
	public function get_nodes($where = ''){
		$this->db->select_from('node');
		
		if(!empty($where)){
			$this->db->where($where);
		}
		
		$this->db->order('node_id')->run();
		
		return $this->db->arr();
	}
}