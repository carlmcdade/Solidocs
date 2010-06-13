<?php
class Solidcms_Controller_Admin_Package extends Solidocs_Controller_Action
{
	/**
	 * Index
	 */
	public function do_index(){
		$this->load->view('Admin_Packages', array(
			'list'	=> $this->model->admin->get_packages()
		));
	}
	
	/**
	 * Install
	 */
	public function do_install(){
		$this->load->model('Install', $this->input->get('package'));
		$this->model->install->install();
		
		$this->forward('Index');
	}

	/**
	 * Uninstall
	 */
	public function do_uninstall(){
		$this->load->model('Install', $this->input->get('package'));
		$this->model->install->uninstall();
		
		$this->forward('Index');
	}
	
	/**
	 * Reinstall
	 */
	public function do_reinstall(){
		$this->load->model('Install', $this->input->get('package'));
		$this->model->install->uninstall();
		$this->model->install->install();
		
		$this->forward('Index');
	}
}