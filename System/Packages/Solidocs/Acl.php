<?php
/**
 * Access Control List
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
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