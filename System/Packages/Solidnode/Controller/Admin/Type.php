<?php
class Solidnode_Controller_Admin_Type extends Solidocs_Controller_Action
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
	 * Edit
	 */
	public function do_edit(){
		$helpers = array(
			'' => '-',
			'form_text' => 'Text field',
			'form_textarea' => 'Textarea',
			'form_select' => 'Select field'
		);
		$types = array(
			'' => '-',
			'text' => 'Text',
			'integer' => 'Integer'
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
	 * Delete field
	 */
	public function do_delete_field(){
		$field = explode(':', $this->input->uri_segment('id'));
		
		$this->model->node->delete_type_field($field[0], $field[1]);
		
		$this->redirect('/admin/type/edit/' . $field[0]);
	}
}