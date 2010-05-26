<?php
class Solidcms_Model_Cms extends Solidocs_Base
{
	/**
	 * Get raw content
	 *
	 * @param array		Optional.
	 * @return array
	 */
	public function get_content($args = array()){
		$content = $this->get_raw_content($args, true);
		
		foreach($content as $i => $item){
			if(empty($item['view'])){
				$content[$i]['view'] = $item['default_view'];
			}
			
			if(empty($item['layout']) AND !empty($item['default_layout'])){
				$content[$i]['layout'] = $item['default_layout'];
			}
			
			if(!empty($item['data'])){
				$content[$i]['data'] = unserialize($item['data']);
			}
		}
		
		if(!isset($content[0])){
			return array();
		}
		
		if(!isset($args['limit'])){
			return $content[0];	
		}
		
		return $content;
	}
	
	/**
	 * Get raw content
	 *
	 * @param array		Optional.
	 * @param bool		Optional.
	 * @return array
	 */
	public function get_raw_content($args = array(), $always_arr = false){
		$defaults = array(
			'limit'		=> 1,
			'order_by'	=> 'time',
			'order'		=> 'ASC'
		);
		
		$args = array_merge($defaults, $args);
		
		$this->db
			->select('solidcms_content.*, solidcms_content_type.default_layout, solidcms_content_type.default_view')
			->from('solidcms_content')
			->join('solidcms_content_type', 'solidcms_content_type.content_type', 'solidcms_content.content_type');
		
		$properties = array('limit', 'order_by', 'order');
		
		foreach($args as $key => $val){
			if(in_array($key, $properties)){
				continue;
			}
			
			if(is_array($val)){
				$this->db->where_in($key, array(
					$val
				));
			}
			else{
				$this->db->where(array(
					$key => $val
				));
			}
		}
		
		$this->db->order($args['order_by'], $args['order'])->limit($args['limit'])->run();
		
		if($args['limit'] == 1 AND $always_arr == false){
			return $this->db->fetch_assoc();
		}
		
		return $this->db->arr();
	}
	
	/**
	 * Process view data
	 *
	 * @param array
	 */
	public function process_view_data($content){
		$view_data = array(
			'title'		=> $content['title'],
			'content'	=> $content['content']
		);
		
		if(is_array($content['data'])){
			$view_data = array_merge($view_data, $content['data']);
		}
		
		return $view_data;
	}
	
	/**
	 * Get content type
	 *
	 * @param string
	 * @return array
	 */
	public function get_content_type($content_type){
	}
}