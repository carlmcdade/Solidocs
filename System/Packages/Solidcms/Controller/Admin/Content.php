<?php
class Solidcms_Controller_Admin_Content extends Solidocs_Controller_Action
{
	/**
	 * Index
	 */
	public function do_index(){
		$content = $this->db->select_from('content')->order('content_id', 'ASC')->run()->arr();
		
		$this->load->view('Admin_Content', array(
			'content' => $content
		));
	}
	
	/**
	 * Types
	 */
	public function do_type(){
		$content_types = $this->db->select_from('content_type')->run()->arr();
		
		$this->load->view('Admin_Types', array(
			'content_types' => $content_types
		));
	}
}