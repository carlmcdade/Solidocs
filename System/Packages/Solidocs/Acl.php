<?php
class Solidocs_Acl extends Solidocs_Base
{
	/**
	 * List
	 */
	public $list = array();
	
	/**
	 * Groups
	 */
	public $groups = array('user', 'admin');
	
	/**
	 * Autoload db
	 */
	public $autoload_db = true;
	
	/**
	 * Init
	 */
	public function init(){
		if($this->autoload_db){
			$this->db->select_from('acl')->run();
			
			if($this->db->affected_rows()){
				while($item = $this->db->fetch_assoc()){
					$this->list[$item['category'] . '::' . $item['key']] = array(
						'group'		=> $item['group'],
						'action'	=> $item['action']
					);
				}
			}
		}
	}
	
	/**
	 * Key
	 *
	 * @param string
	 * @param string
	 * @return string
	 */
	public function _key($category, $key){
		if(is_object($category)){
			$category = get_class($category);
		}
		
		return $category . '::' . $key;
	}
	
	/**
	 * Set access
	 *
	 * @param object|string
	 * @param string
	 * @param string
	 * @param string|bool
	 */
	public function set_access($category, $key, $group, $action = false){
		$this->list[$this->_key($category, $key)] = array(
			'group'		=> $group,
			'action'	=> $action
		);
	}
	
	/**
	 * Has access
	 *
	 * @param object|string
	 * @param string
	 * @return bool
	 */
	public function has_access($category, $key){
		$key = $this->_key($category, $key);
		
		if(isset($this->list[$key])){
			if(!$this->model->user->in_group($this->list[$key]['group'])){
				return false;
			}
		}
		
		return true;
	}
	
	/**
	 * Get action
	 *
	 * @param object|string
	 * @param string
	 * @return string|bool
	 */
	public function get_action($category, $key){
		return $this->list[$this->_key($category, $key)]['action'];
	}
}