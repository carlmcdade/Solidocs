<?php
class Solidadmin_Controller_Admin_Admin extends Solidocs_Controller_Action
{
	/**
	 * Index
	 */
	public function do_index(){
		$form = new Solidocs_Form;
		$form->set_action($this->router->request_uri);
		$form->set_method('post');
		$form->add_element('item', array(
			'type' => 'text',
			'label' => 'Item:',
			'filters' => array('trim', 'strtolower'),
			'validators' => array(
				'Strlen' => array(2, 64)
			),
			'helper' => array('form_text')
		))->add_element('controller', array(
			'type' => 'text',
			'label' => 'Controller:',
			'filters' => array('trim'),
			'validators' => array(
				'Strlen' => array(2, 64)
			),
			'helper' => array('form_text')
		))->add_element('submit', array(
			'type' => 'button',
			'helper' => array('form_button', 'Save item')
		));
		
		if($form->is_posted()){
			if($form->is_valid()){
				$form->process_values();
				
				$this->db->insert_into('admin', $form->get_values())->run();
			}
		}
		
		$this->load->view('Admin_Admin', array(
			'items' => $this->model->admin->get_items(),
			'form' => $form
		));
	}
	
	/**
	 * Delete
	 */
	public function do_delete(){
		$this->db->delete_from('admin')->where(array(
			'item' => $this->input->uri_segment('id')
		))->run();
		
		$this->redirect('/admin/admin');
	}
}