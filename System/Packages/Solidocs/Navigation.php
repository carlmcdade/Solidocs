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
			$data = $this->db->select_from('navigation')->where(array(
				'key' => $data
			))->order('order')->run()->arr();
		}
		
		return $data;
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
		$menu = new Solidocs_Navigation_Menu($this->_data($data), $args, $this->router->request_uri);
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
		$breadcrumb = new Solidocs_Navigation_Breadcrumb($this->_data($data), $args, $this->router->request_uri);
		return $breadcrumb->render();
	}
}