<?php
class Solidocs_User extends Solidocs_Base
{
	/**
	 * Init
	 */
	public function init(){
		$this->load->model('User');
	}
	
	/**
	 * Call
	 *
	 * @param string
	 * @param array
	 */
	public function __call($method, $params){
		if(!method_exists($this->model->user, $method)){
			throw new Exception('The method "' . $method . '" is not supported in your user model');
		}
		
		return call_user_func_array(array($this->model->user, $method), $params);
	}
}