<?php
class Solidocs_Controller_Action extends Solidocs_Controller
{
	/**
	 * Call
	 *
	 * @param string
	 * @param array
	 */
	public function __call($action, $params){
		throw new Exception('Action "' . $action . '" could not be found', 404);
	}
	
	/**
	 * Dispatch action
	 *
	 * @param string
	 */
	public function dispatch_action($action){
		$action = strtolower($action);
		
		if(isset($this->model->user) AND is_object($this->acl) AND !$this->acl->has_access($this, $action)){
			$action = $this->acl->get_action($this, $action);
			
			if($action == false){
				return false;
			}
		}
		
		call_user_func(array($this, 'do_' . $action));
	}
	
	/**
	 * Forward
	 *
	 * @param string
	 */
	public function forward($action){
		$this->dispatch_action($action);
	}
}