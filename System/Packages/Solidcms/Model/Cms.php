<?php
class Solidcms_Model_Cms extends Solidocs_Base
{
	/**
	 * Get content
	 *
	 * @param array
	 * @param integer	Optional.
	 * @param string	Optional.
	 * @param string	Optional.
	 * @return array
	 */
	public function get_content($args, $limit = 1, $order_by = 'time', $order = 'ASC'){
		$this->db->select()->from('content')
		
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
		
		return $this->db->limit($limit)->order($order_by, $order)->run()->arr();
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