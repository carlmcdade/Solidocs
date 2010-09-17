<?php
/**
 * User Group Administration Controller
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Admin
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Admin_Controller_Admin_Group extends Solidocs_Controller_Action
{
	/**
	 * Index
	 */
	public function do_index(){
		$this->db->select_from('group')->run();
		
		$this->load->view('Admin_Group_List', array(
			'groups' => $this->db->arr()
		));
	}
	
	/**
	 * Add
	 */
	public function do_add(){
		if($this->input->has_post('name')){
			$this->load->library('Text');
			
			$this->db->insert_into('group', array(
				'group'			=> $this->text->slug($this->input->post('name')),
				'name'			=> $this->input->post('name'),
				'description'	=> $this->input->post('description')
			))->run();
			
			$this->output->add_flash_message('success', 'The group was successfully added');
			
			$this->redirect('/admin/group');
		}
		
		$this->load->view('Admin_Group_Add');
	}
	
	/**
	 * Delete
	 */
	public function do_delete(){
		$this->db->delete_from('group')->where(array(
			'group' => $this->input->uri_segment('id')
		))->run();
		
		$this->output->add_flash_message('success', 'The group was successfully deleted');
		
		$this->redirect('/admin/group');
	}
}