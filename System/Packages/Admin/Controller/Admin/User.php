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
			$email		= $this->input->post('email');
			$salt		= $this->user->generate_salt();
			$password	= $this->user->password($this->input->post('password'), $salt);
			$group		= $this->input->post('group');
			
			$data = array(
				'email'		=> $email,
				'password'	=> $password,
				'salt'		=> $salt,
				'group'		=> $group
			);
			
			$this->db->insert_into('user', $data)->run();
			
			$this->output->add_message('success', 'The user was successfully created');
		}
		
		$groups = array();
		
		$this->db->select_from('group')->run();
		
		while($item = $this->db->fetch_assoc()){
			$groups[$item['group']] = $item['name'];
		}
		
		$this->load->view('Admin_User_Add', array(
			'groups' => $groups
		));
	}
	
	/**
	 * Edit
	 */
	public function do_edit(){
		if($this->input->has_post('email')){
			$data = $_POST;
			$data['group'] = implode(',', $data['group']);
			
			if(!empty($data['password'])){
				$data['salt'] 		= $this->user->generate_salt();
				$data['password']	= $this->user->password($data['password'], $data['salt']);
			}
			else{
				unset($data['password']);
			}
			
			$this->db->update_set('user', $data)->where(array(
				'user_id' => $this->input->uri_segment('id')
			))->run();
			
			$this->output->add_message('success', 'The user was successfully updated');
		}
		
		$this->db->select_from('user')->where(array(
			'user_id' => $this->input->uri_segment('id')
		))->run();
		
		$data = array(
			'user' 		=> $this->db->fetch_assoc(),
			'groups'	=> $this->db->select_from('group')->run()->arr()
		);
		
		$data['user']['group'] = explode(',', $data['user']['group']);
		
		$this->load->view('Admin_User_Edit', $data);
	}
	
	/**
	 * Delete
	 */
	public function do_delete(){
		$this->db->delete_from('user')->where(array(
			'user_id' => $this->input->uri_segment('id')
		))->run();
		
		$this->output->add_flash_message('success', 'The user was deleted');
		
		$this->redirect('/admin/user');
	}
}