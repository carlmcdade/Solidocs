<?php
class Solidcms_Controller_Admin_Dashboard extends Solidocs_Controller_Action
{
	/**
	 * Index
	 */
	public function do_index(){
		$this->load->view('Admin_Dashboard');
	}
}