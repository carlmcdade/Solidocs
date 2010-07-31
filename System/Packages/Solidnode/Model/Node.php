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
	 * @return array
	 */
	public function get_nodes($where = ''){
		$this->db->select_from('node');
		
		if(!empty($where)){
			$this->db->where($where);
		}
		
		$this->db->order('node_id')->run();
		
		return $this->db->arr();
	}
	
	/**
	 * Get type fields
	 *
	 * @param string
	 * @return array
	 */
	public function get_type_fields($content_type){
		$this->db->select_from('content_type_field', 'field,name,helper,type,filters,validators')->where(array(
			'content_type' => $content_type
		))->run();
		
		$fields = array();
		
		while($item = $this->db->fetch_assoc()){
			$fields[$item['field']] = $item;
		}
		
		return $fields;
	}
	
	/**
	 * Get types
	 *
	 * @return array
	 */
	public function get_types(){
		$this->db->select_from('content_type')->run();
		
		return $this->db->arr('content_type');
	}
	
	/**
	 * Update
	 *
	 * @param integer
	 * @param array
	 */
	public function update($node_id, $node){
		if(is_array($node['content'])){
			$node['content'] = serialize($node['content']);
		}
		
		$this->db->update_set('node', $node)->where(array(
			'node_id' => $node_id
		))->run();
	}
	
	/**
	 * Create
	 *
	 * @param array
	 */
	public function create($node){
		
	}
}