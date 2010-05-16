<?php
class Application_Controller_Test extends Solidocs_Controller_Action
{
	/**
	 * Index
	 */
	public function do_index(){
		$this->load->view('Index');
	}
	
	/**
	 * About
	 */
	public function do_about(){
		$this->load->view('About');
	}
}