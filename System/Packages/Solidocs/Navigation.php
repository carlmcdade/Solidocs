<?php
/**
 * Navigation
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
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
		    	))->order('order')->run();
		    	
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
	 * Call
	 *
	 * @param string
	 * @param array
	 * @return string
	 */
	public function __call($method, $params){
		$method = explode('_', $method);
		$get = false;
		
		if($method[0] == 'get'){
			$get = true;
			
			$library = $this->load->get_library('Navigation_' . ucfirst($method[1]));
		}
		else{
			$library = $this->load->get_library('Navigation_' . ucfirst($method[0]));
		}
		
		$library->set_data($this->_data($params[0]));
		$library->set_active_url($this->router->uri);
		
		if(isset($params[1])){
			$library->set_args($params[1]);
		}
		
		if($get){
			return $library->render();
		}
		
		echo $library->render();
	}
}