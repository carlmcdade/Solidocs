<?php
/**
 * Application User Controller
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Application_Controller_User extends Solidocs_Controller_Action
{
	/**
	 * Login
	 */
	public function do_login(){
		$form = new Application_Form_Login;
		
		if($form->is_posted()){
			$form->process_values();
			
			$this->load->library('Auth');	
						
			if($form->is_posted()){
				if($form->is_valid()){
					$this->auth->auth('default', $form->get_values());
					
					if($this->auth->is_authed()){
						$this->redirect($this->input->get('redirect', '/'));
					}
					else{
						$this->output->add_message('error', 'Your credentials were not accepted - please try again', 'Either your e-mail or password were wrong.');
					}
				}
				else{
					$this->output->add_message('error', 'Your password must be at least 6 letters.');
				}
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