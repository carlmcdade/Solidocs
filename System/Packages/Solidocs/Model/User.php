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
	 * Auth
	 *
	 * @param string
	 * @param string
	 * @return bool
	 */
	public function auth($user, $password){
		$this->db->select_from('user')->where_or(array(
			array(
				'email'		=> $user,
				'password'	=> $password
			),
			array(
				'username'	=> $user,
				'password'	=> $password
			)
		))->limit(1)->run();
		
		if($this->db->affected_rows() !== 0){
			$array = $this->db->fetch_assoc();
			unset($array['password']);
			
			$this->session->user			= $array;
			$this->session->user['group']	= explode(',', $this->session->user['group']);
			$this->user						= &$this->session->user;
			
			return true;
		}
		
		return false;
	}
	
	/**
	 * In group
	 *
	 * @param integer
	 * @return bool
	 */
	public function in_group($group){
		if(is_null($this->user)){
			return false;
		}
		
		return in_array($group, $this->user->group);
	}
}