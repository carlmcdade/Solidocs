<?php
/**
 * Action Controller
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
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
			
			if(is_array($action) AND $action[0] == 'route' OR $action[0] == 'uri'){
				if($action[0] == 'route'){
					$query = null;
					
					if(isset($action[2])){
						$query = $action[2];
					}
					
					$uri = $this->router->assemble($action[1], null, $query);
				}
				else{
					$uri = $action[1];
				}
				
				$this->redirect($uri);
				return false;
			}
			
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