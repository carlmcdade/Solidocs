<?php
/**
 * User Administration Controller
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Admin
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Admin_Controller_Admin_User extends Solidocs_Controller_Action
{
	/**
	 * Index
	 */
	public function do_index(){
		$this->db->select_from('user')->run();
		
		$this->load->view('Admin_User_List', array(
			'users' => $this->db->arr()
		));
	}
	
	/**
	 * Add
	 */
	public function do_add(){
		if($this->input->has_post()){
			$email = $this->input->post('email');
			$salt = $this->user->generate_salt();
			$password = $this->user->password($this->input->post('password'), $salt);
			$group = $this->input->post('group');
			
			$data = array(
				'email' => $email,
				'password' => $password,
				'salt' => $salt,
				'group' => $group
			);
			
			$this->db->insert_into('user', $data)->run();
			
			$this->output->add_message('success', 'The user was successfully created');
		}
		
		$this->load->view('Admin_User_Add');
	}
}