<?php
/**
 * Node Model
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Node
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php
 */
class Node_Model_Node extends Solidocs_Base
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
		
		$node = $this->process_node($this->db->fetch_assoc());
		
		return Solidocs::apply_filter('node', $node);
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
		
		$nodes = array();
		
		while($node = $this->db->fetch_assoc()){
			$nodes[] = $this->process_node($node);
		}
		
		return Solidocs::apply_filter('nodes', $nodes);
	}
	
	/**
	 * Query nodes
	 *
	 * @param array
	 * @param integer		Optional.
	 * @param string|array	Optional.
	 * @return array
	 */
	public function query_nodes($args, $limit = null, $fields = ''){
		$this->db->select_from('node', $fields);
		
		foreach($args as $key => $val){
			switch($key){
				case 'type':
					$this->db->where(array('content_type' => $val));
				break;
				
				case 'category':
					$this->db->where(array('category' => $val));
				break;
				
				case 'locale':
					$this->db->where(array('locale' => $val));
				break;
				
				case 'tags':
					$tags = array();
					
					foreach($val as $val){
						$tags[] = 'LIKE %' . $val . '%';
					}
					
					$this->db->where(array('tags' => $tags));
				break;
				
				case 'published':
					$this->db->where(array('published' => $val));
				break;
				
				case 'id':
					$this->db->where(array('node_id' => $val));
				break;
			}
		}
		
		if(!is_null($limit)){
			$this->db->limit($limit);
		}
		
		$this->db->run();
		
		$nodes = array();
		
		if($this->db->affected_rows()){
			while($node = $this->db->fetch_assoc()){
				$node = $this->process_node($node);
				
				$match = true;
				
				if(isset($args['content'])){
					foreach($args['content'] as $key => $val){
						if($node->content[$key] !== $val){
							$match = false;
						}
					}
				}
				
				if($match){
					$nodes[] = $node;
				}
			}
		}
		
		return Solidocs::apply_filter('nodes', $nodes);
	}
	
	/**
	 * Process node
	 *
	 * @param array
	 * @return object
	 */
	public function process_node($node){
		$node = (object) $node;
		
		if(is_serialized($node->content)){
			$node->content = unserialize($node->content);
			
			foreach($node->content as $key => $val){
				if(!is_array($val)){
					$node->$key = stripslashes($val);
				}
				else{
					$node->$key = $val;
				}
			}
		}
		
		return $node;
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
	
	/**
	 * Delete
	 *
	 * @param integer
	 */
	public function delete($node_id){
		$this->db->delete_from('node')->where(array(
			'node_id' => $node_id
		))->run();
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
	 * Add type
	 */
	public function add_type($content_type){
		$this->db->insert_into('content_type', $content_type)->run();
	}
	
	/**
	 * Update type
	 */
	public function update_type($content_type, $data){}
	
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
	 * Get category
	 *
	 * @param string
	 * @return array
	 */
	public function get_category($category){
		return $this->db->select_from('category')->where(array(
			'category' => $category
		))->run()->fetch_assoc();
	}
	
	/**
	 * Get categories
	 *
	 * @return array
	 */
	public function get_categories(){
		return $this->db->select_from('category')->run()->arr();
	}
	
	/**
	 * Add category
	 *
	 * @param array
	 */
	public function add_category($data){
		$this->db->insert_into('category', $data)->run();
	}
	
	/**
	 * Update category
	 *
	 * @param string
	 * @param array
	 */
	public function update_category($category, $data){
		$this->db->update_set('category', $data)->where(array(
			'category' => $this->input->uri_segment('id')
		))->run();
	}
	
	/**
	 * Delete category
	 *
	 * @param string
	 */
	public function delete_category($category){
		$this->db->delete_from('category')->where(array(
			'category' => $this->input->uri_segment('id')
		))->run();
	}
}