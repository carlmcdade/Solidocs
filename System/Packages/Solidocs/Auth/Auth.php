<?php
class Solidocs_Auth_Auth extends Solidocs_Base
{
	/**
	 * Identity
	 */
	public $identity;
	
	/**
	 * Set identity
	 *
	 * @param array
	 */
	public function set_identity($identity){
		$this->identity = $identity;
	}
	
	/**
	 * Get identity
	 *
	 * @return array
	 */
	public function get_identity(){
		return $this->identity;
	}
}