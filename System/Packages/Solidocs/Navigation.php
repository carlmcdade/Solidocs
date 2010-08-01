<?php
class Solidocs_Navigation extends Solidocs_Base
{
	/**
	 * Data
	 *
	 * @param string|array
	 * @return array
	 */
	public function _data($data){
		if(is_string($data)){
			$data = $this->_data_part($data, 0);
		}
		
		return $data;
	}
	
	/**
	 * Data part
	 *
	 * @param string
	 * @param integer
	 */
	public function _data_part($navigation_key, $parent_id){
		$this->db->select_from('navigation_item')->where(array(
		    'key' => $navigation_key,
		    'parent_id' => $parent_id
		))->order('order')->run();
		
		if($this->db->affected_rows()){
		    $data = $this->db->arr();
		    
		    foreach($data as $key => $val){
		    	$children = $this->_data_part($navigation_key, $val['navigation_item_id']);
		    	
		    	if(is_array($children)){
		    		$data[$key]['children'] = $children;
		    	}
		    	
		    	$this->db->select_from('navigation_item')->where(array(
		    		'key' => $navigation_key,
		    		'parent_id' => $val['navigation_item_id']
		    	))->run();
		    	
		    	if($this->db->affected_rows()){
		    		$data[$key]['children'] = $this->db->arr();
		    	}
		    }
		    
		    return $data;
		}
		
		return false;
	}
	
	/**
	 * Get navigation
	 *
	 * @param string
	 * @return array
	 */
	public function get_navigation($key){
		return $this->_data($key);
	}
	
	/**
	 * Get navigations
	 *
	 * @return array
	 */
	public function get_navigations(){
		return $this->db->select_from('navigation')->run()->arr();
	}
	
	/**
	 * Menu
	 *
	 * @param string|array
	 * @param string|array	Optional.
	 */
	public function menu($data, $args = ''){
		echo $this->get_menu($data, $args);
	}
	
	/**
	 * Breadcrumb
	 *
	 * @param string|array
	 * @param string|array	Optional.
	 */
	public function breadcrumb($data, $args = ''){
		echo $this->get_breadcrumb($data, $args);
	}
	
	/**
	 * Get menu
	 *
	 * @param string|array
	 * @param string|array	Optional.
	 * @return string
	 */
	public function get_menu($data, $args = ''){
		$menu = new Solidocs_Navigation_Menu($this->_data($data), $args, $this->router->uri);
		return $menu->render();
	}
	
	/**
	 * Get breadcrumb
	 *
	 * @param string|array
	 * @param string|array
	 * @return string
	 */
	public function get_breadcrumb($data, $args = ''){
		$breadcrumb = new Solidocs_Navigation_Breadcrumb($this->_data($data), $args, $this->router->uri);
		return $breadcrumb->render();
	}
}