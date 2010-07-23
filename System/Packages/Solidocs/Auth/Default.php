<?php
class Solidocs_Auth_Default extends Solidocs_Base
{
	/**
	 * Identity
	 */
	public $identity;
	
	/**
	 * Auth
	 *
	 * @param string	$email
	 * @param string	$password
	 * @return bool
	 */
	public function auth($email = '', $password = ''){
		if(empty($email) OR empty($password)){
			return false;
		}
		
		$this->db->select_from('user')->where(array(
			'email' => $email,
			'password' => $password
		))->run();
		
		if($this->db->affected_rows()){
			$this->set_identity($this->db->fetch_assoc());
			
			return true;
		}
		
		return false;
	}
	
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