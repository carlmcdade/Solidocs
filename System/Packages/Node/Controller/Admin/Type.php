<?php
/**
 * Node Type Admin Controller
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Node
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Node_Controller_Admin_Type extends Solidocs_Controller_Action
{
	/**
	 * Init
	 */
	public function init(){
		$this->load->model('Node');
	}
	
	/**
	 * Index
	 */
	public function do_index(){
		$this->load->view('Admin_Content_Types', array(
			'content_types' => $this->model->node->get_types()
		));
	}
	
	/**
	 * Create
	 */
	public function do_create(){
		if($this->input->has_post()){
			$this->model->node->add_type($_POST);
			
			$this->redirect('/admin/type/edit/' . $_POST['content_type']);
		}
		
		$this->load->view('Admin_Content_TypeCreate');
	}
	
	/**
	 * Edit
	 */
	public function do_edit(){
		$this->db->select_from('content_type_helper')->run();
		$helpers = array();
		
		while($item = $this->db->fetch_assoc()){
			$helpers[$item['helper']] = $item['name'];
		}
		
		$types = array(
			'-'			=> '-',
			'text'		=> 'Text',
			'integer'	=> 'Integer',
			'array'		=> 'Array',
			'file'		=> 'File',
			'bool'		=> 'Boolean'
		);
		
		if(isset($_POST['new_field'])){
			if(!empty($_POST['new_field']['field'])){
				$this->model->node->add_type_field($this->input->uri_segment('id'), $_POST['new_field']);
			}
			
			unset($_POST['new_field']);
		}
		
		if($this->input->has_post()){
			foreach($_POST as $field => $data){
				$this->model->node->update_type_field($this->input->uri_segment('id'), $field, $data);
			}
		}
		
		$this->load->view('Admin_Content_TypeEdit', array(
			'fields' => $this->model->node->get_type_fields($this->input->uri_segment('id')),
			'helpers' => $helpers,
			'types' => $types
		));
	}
	
	/**
	 * Delete
	 */
	public function do_delete(){
		$this->model->node->delete_type($this->input->uri_segment('id'));
		
		$this->redirect('/admin/type');
	}
	
	/**
	 * Delete field
	 */
	public function do_delete_field(){
		$field = explode(':', $this->input->uri_segment('id'));
		
		$this->model->node->delete_type_field($field[0], $field[1]);
		
		$this->redirect('/admin/type/edit/' . $field[0]);
	}
}