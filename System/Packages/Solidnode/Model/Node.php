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
			
			foreach($node->content as $key => $val){
				$node->$key = $val;
			}
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
	 * Add type
	 */
	public function add_type($content_type){
		$this->db->insert_into('content_type', $content_type)->run();
	}
	
	/**
	 * Delete type
	 */
	public function delete_type($content_type){
		$this->db->delete_from('content_type')->where(array(
			'content_type' => $content_type
		))->run();
		
		$this->db->delete_from('content_type_field')->where(array(
			'content_type' => $content_type
		))->run();
	}
	
	/**
	 * Add type field
	 *
	 * @param string
	 * @param array
	 */
	public function add_type_field($content_type, $data){
		$data['content_type'] = $content_type;
		$this->db->insert_into('content_type_field', $data)->run();
	}
	
	/**
	 * Update type field
	 *
	 * @param string
	 * @param array
	 */
	public function update_type_field($content_type, $field, $data){
		$this->db->update_set('content_type_field', $data)->where(array(
			'content_type' => $content_type,
			'field' => $field
		))->run();
	}
	
	/**
	 * Delete type field
	 *
	 * @param string
	 * @param string
	 */
	public function delete_type_field($content_type, $field){
		$this->db->delete_from('content_type_field')->where(array(
			'content_type' => $content_type,
			'field' => $field
		))->run();
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
			if(count($node['content']) == 1 AND isset($node['content']['content'])){
				$node['content'] = $node['content']['content'];
			}
			else{
				$node['content'] = serialize($node['content']);
			}
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
		if(is_array($node['content'])){
			if(count($node['content']) == 1 AND isset($node['content']['content'])){
				$node['content'] = $node['content']['content'];
			}
			else{
				$node['content'] = serialize($node['content']);
			}
		}
		
		$this->db->insert_into('node', $node)->run();
	}
}