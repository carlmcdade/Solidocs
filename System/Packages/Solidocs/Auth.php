<?php
class Solidocs_Auth extends Solidocs_Base
{
	/**
	 * Authenticate
	 *
	 * @param string
	 * @param array
	 * @return bool
	 */
	public function auth($adapter = 'default', $data){
		$library = $this->load->get_library('Auth_' . ucfirst($adapter));
		
		$result = call_user_func_array(array($library, 'auth'), $data);
		
		if($result){
			$this->session->user = $library->get_identity();
		}
		
		return $result;
	}
}