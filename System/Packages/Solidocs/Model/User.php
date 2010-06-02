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
}