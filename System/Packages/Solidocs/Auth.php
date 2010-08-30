<?php
/**
 * Authentication
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
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
}