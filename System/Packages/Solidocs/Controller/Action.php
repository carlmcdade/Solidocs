<?php
class Solidocs_Controller_Action extends Solidocs_Controller
{
	/**
	 * Acl
	 */
	public $acl;
	
	/**
	 * Set access
	 *
	 * @param string
	 * @param integer
	 * @param string|bool
	 */
	public function set_access($action, $level, $do = false){
		$this->acl[$action] = array(
			'level'	=> $level,
			'do'	=> '404'
		);
	}
	
	/**
	 * Dispatch action
	 *
	 * @param string
	 */
	public function dispatch_action($action){
		$action = strtolower($action);
		
		if(isset($this->model->user) AND isset($this->acl[$action]) AND !$this->model->user->has_access($this->acl[$action]['level'])){
			if($this->acl[$action]['do'] == false){
				return false;
			}
			
			$action = $this->acl[$action]['do'];
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