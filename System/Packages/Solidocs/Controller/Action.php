<?php
class Solidocs_Controller_Action extends Solidocs_Controller
{
	/**
	 * Dispatch action
	 *
	 * @param string
	 */
	public function dispatch_action($action){
		$action = strtolower($action);
		
		if(isset($this->model->user) AND is_object($this->acl) AND !$this->acl->has_access($this, $action)){
			$action = $this->acl->action($this, $action);
			
			if($action == false){
				return false;
			}
		}
		
		if(method_exists($this, 'do_' . $action)){
			$action = 'do_' . $action;
		}
		else{
			$action = 'do_404';
		}
		
		$this->$action();
	}
	
	/**
	 * Forward
	 *
	 * @param string
	 */
	public function forward($action){
		$this->dispatch_action($action);
	}
	
	/**
	 * 404
	 */
	public function do_404(){
		$this->load->view('404');
	}
}