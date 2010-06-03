<?php
class Solidocs_Model_User extends Solidocs_Base
{
	/**
	 * Current
	 */
	public $user = null;
	
	/**
	 * Init
	 */
	public function init(){
		if(isset($this->session->user)){
			$this->user	= &$this->session->user;
		}
	}
	
	/**
	 * Has session
	 *
	 * @return bool
	 */
	public function has_session(){
		return !is_null($this->user);
	}
	
	/**
	 * Has access
	 *
	 * @param integer
	 * @return bool
	 */
	public function has_access($level, $exact = false){
		if(!isset($this->user->access_level)){
			return false;
		}
		
		if($exact){
			return ($this->user->access_level == $level);
		}
		
		return ($this->user->access_level >= $level);
	}
}