<?php
class Solidocs_Acl extends Solidocs_Base
{
	/**
	 * List
	 */
	public $list = array();
	
	/**
	 * Set access
	 *
	 * @param object|string
	 * @param string
	 * @param integer
	 * @param string|bool
	 */
	public function set_access($class, $action, $level, $do = false){
		if(is_object($class)){
			$class = get_class($class);
		}
		
		$this->list[$class][$action] = array(
			'level'		=> $level,
			'action'	=> $do
		);
	}
	
	/**
	 * Has access
	 *
	 * @param object|string
	 * @param string
	 * @return bool
	 */
	public function has_access($class, $action){
		if(is_object($class)){
			$class = get_class($class);
		}
		
		if(isset($this->list[$class][$action])){
			if(!$this->model->user->has_access($this->list[$class][$action]['level'])){
				return false;
			}
		}
		
		return true;
	}
	
	/**
	 * Action
	 *
	 * @param object|string
	 * @param string
	 * @return string|bool
	 */
	public function action($class, $action){
		if(is_object($class)){
			$class = get_class($class);
		}
		
		return $this->list[$class][$action]['action'];
	}
}