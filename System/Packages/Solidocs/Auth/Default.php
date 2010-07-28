<?php
class Solidocs_Auth_Default extends Solidocs_Auth_Auth
{
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
		
		$this->db->select_from('user', 'salt')->where(array(
			'email' => $email
		))->run();
		
		if(!$this->db->affected_rows()){
			return false;
		}
		
		$salt = $this->db->one();
		
		$this->db->select_from('user')->where(array(
			'email' => $email,
			'password' => $this->auth->password($password, $salt)
		))->run();
		
		if($this->db->affected_rows() == 1){
			$this->set_identity($this->db->fetch_assoc());
			
			return true;
		}
		
		return false;
	}
}