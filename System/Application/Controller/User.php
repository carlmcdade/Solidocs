<?php
class Application_Controller_User extends Solidocs_Controller_Action
{
	/**
	 * Login
	 */
	public function do_login(){
		$form = new Application_Form_Login;
		
		if($form->is_posted()){
			$form->process_values();
			
			if($form->is_valid()){
				$this->load->library('Auth');
				$this->auth->auth('default', $form->get_values());
				
				if($this->auth->is_authed()){
					$this->redirect($this->input->get('redirect', '/'));
				}
				
				#debug($this->db->queries);
			}
		}
		
		$this->load->view('Login', array(
			'form' => $form
		));
	}
	
	/**
	 * Logout
	 */
	public function do_logout(){
		$this->load->library('Auth');
		$this->auth->deauth('default');
		
		$this->redirect('login');
	}
}