<?php
/**
 * User
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
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
	
	/**
	 * Password
	 *
	 * @param string
	 * @param string
	 * @return string
	 */
	public function password($password, $salt){
		return md5(sha1($password . $salt));
	}
	
	/**
	 * Generate salt
	 *
	 * @return string
	 */
	public function generate_salt(){
		return md5(uniqid());
	}
	
	/**
	 * Get salt
	 *
	 * @param string
	 * @return string|salt
	 */
	public function get_salt($email){
		$this->db->select_from('user', 'salt')->where(array(
			'email' => $email
		))->run();
		
		if(!$this->db->affected_rows()){
			return false;
		}
		
		return $this->db->one();
	}
}