<?php
class Node_Controller_Admin_Category extends Solidocs_Controller_Action
{
	/**
	 * Init
	 */
	public function init(){
		$this->load->model('Node');
		$this->load->library('Text');
	}
	
	/**
	 * Index
	 */
	public function do_index(){
		$this->load->view('Admin_Content_Categories', array(
			'categories' => $this->model->node->get_categories()
		));
	}
	
	/**
	 * Create
	 */
	public function do_create(){
		if(isset($_POST['name'])){
			$data = $_POST;
			$data['category'] = $this->text->slug($data['name']);
			
			$this->model->node->add_category($data);
			$this->redirect('/admin/category');
		}
		
		$this->load->view('Admin_Content_CategoryCreate');
	}
	
	/**
	 * Edit
	 */
	public function do_edit(){
		if(isset($_POST['name'])){
			$data = $_POST;
			$data['category'] = $this->text->slug($data['name']);
			
			$this->model->node->update_category($this->input->uri_segment('id'), $data);
			$this->redirect('/admin/category');
		}
		
		$this->load->view('Admin_Content_CategoryEdit', array(
			'category' => $this->model->node->get_category($this->input->uri_segment('id'))
		));
	}
	
	/**
	 * Delete
	 */
	public function do_delete(){
		$this->model->node->delete_category($this->input->uri_segment('id'));
		
		$this->redirect('/admin/category');
	}
}