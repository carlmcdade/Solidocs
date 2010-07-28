<?php
class Solidocs_Auth extends Solidocs_Base
{
	/**
	 * Get adapter
	 *
	 * @param string
	 * @return object
	 */
	public function get_adapter($adapter){
		return $this->load->get_library('Auth_' . ucfirst($adapter));
	}
	
	/**
	 * Authenticate
	 *
	 * @param string
	 * @param array
	 * @return bool
	 */
	public function auth($adapter = 'default', $data){
		$adapter = $this->get_adapter($adapter);
		$authed = call_user_func_array(array($adapter, 'auth'), $data);
		
		if($authed){
			$this->session->user = $adapter->get_identity();
		}
	}
	
	/**
	 * Deauthenticate
	 *
	 * @param string
	 */
	public function deauth($adapter = 'default'){
		$adapter = $this->get_adapter($adapter);
		
		if(method_exists($adapter, 'deauth')){
			$adapter->deauth();
		}
		
		unset($this->session);
		session_destroy();
	}
	
	/**
	 * Is authed
	 *
	 * @return bool
	 */
	public function is_authed(){
		if(isset($this->session->user)){
			return true;
		}
		
		return false;
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
}