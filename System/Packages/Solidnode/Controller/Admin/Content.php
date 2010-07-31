<?php
class Solidnode_Controller_Admin_Content extends Solidocs_Controller_Action
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
		$this->load->view('Admin_Content_List', array(
			'nodes' => $this->model->node->get_nodes()
		));
	}
	
	/**
	 * Edit
	 */
	public function do_edit(){
		$node_id = $this->input->uri_segment('id', 0);
		
		if($node_id == 0){
			// new
		}
		else{
			$node = $this->db->select_from('node')->where(array(
				'node_id' => $node_id
			))->run();
		}
		
		/*
		 * Construct content type fields with Solidocs_Form
		 */
	}
}