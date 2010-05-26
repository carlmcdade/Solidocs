<?php
class Solidcms_Model_Cms extends Solidocs_Base
{
	/**
	 * Get raw content
	 *
	 * @param array|string
	 * @param integer		Optional.
	 * @param string		Optional.
	 * @param string		Optional.
	 * @return array
	 */
	public function get_content($args, $limit = 1, $order_by = 'time', $order = 'ASC'){
		$content = $this->get_raw_content($args, $limit, $order_by, $order, true);
		
		foreach($content as $i => $item){
			if(empty($item['view'])){
				$content[$i]['view'] = $item['default_view'];
			}
		}
		
		if(!isset($content[0])){
			return array();
		}
		
		if($limit == 1){
			return $content[0];	
		}
		
		return $content;
	}
	
	/**
	 * Get raw content
	 *
	 * @param array|string
	 * @param integer		Optional.
	 * @param string		Optional.
	 * @param string		Optional.
	 * @param bool			Optional.
	 * @return array
	 */
	public function get_raw_content($args, $limit = 1, $order_by = 'time', $order = 'ASC', $always_arr = false){
		$this->db
			->select('solidcms_content.*, solidcms_content_type.default_layout, solidcms_content_type.default_view')
			->from('solidcms_content')
			->join('solidcms_content_type', 'solidcms_content_type.content_type', 'solidcms_content.content_type');
		
		if(is_array($args)){
			foreach($args as $key => $val){
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
		}
		
		$this->db->order($order_by, $order)->limit($limit)->run();
		
		if($limit == 1 AND $always_arr == false){
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
		
		if(is_serialized($content['data'])){
			$view_data = array_merge($view_data, unserialize($content['data']));
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