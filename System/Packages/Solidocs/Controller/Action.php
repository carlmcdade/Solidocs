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
		
		if(method_exists($this,'do_'.$action)){
			$action = 'do_'.$action;
		}
		
		$this->$action();
	}
}