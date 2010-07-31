<?php
class Solidnode_Controller_Admin_Content extends Solidocs_Controller_Action
{
	/**
	 * Index
	 */
	public function do_index(){
		$this->load->view('Admin_Content_List');
	}
}