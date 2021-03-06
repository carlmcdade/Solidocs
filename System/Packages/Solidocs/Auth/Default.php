<?php
/**
 * Default Authentication
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
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
		
		$salt = $this->user->get_salt($email);
		
		if($salt == false){
			return false;
		}
		
		$this->db->select_from('user', 'user_id,email,group')->where(array(
			'email' => $email,
			'password' => $this->user->password($password, $salt)
		))->run();
		
		if($this->db->affected_rows() == 1){
			$this->set_identity($this->db->fetch_assoc());
			
			return true;
		}
		
		return false;
	}
}