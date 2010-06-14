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
	 * Plugin
	 */
	public function do_plugin(){
		$this->load->view('Admin_Plugins', array(
			'list'	=> $this->model->admin->get_plugins()
		));
	}
	
	/**
	 * Install package
	 */
	public function do_install_package(){
		$this->load->model('Install', $this->input->get('package'));
		$this->model->install->install();
		
		$this->forward('Index');
	}

	/**
	 * Uninstall package
	 */
	public function do_uninstall_package(){
		$this->load->model('Install', $this->input->get('package'));
		$this->model->install->uninstall();
		
		$this->forward('Index');
	}
	
	/**
	 * Reinstall package
	 */
	public function do_reinstall_package(){
		$this->load->model('Install', $this->input->get('package'));
		$this->model->install->uninstall();
		$this->model->install->install();
		
		$this->forward('Index');
	}
	
	/**
	 * Install plugin
	 */
	public function do_install_plugin(){
		$class = $this->input->get('plugin');
		$instance = new $class;
		
		$instance->install();
		
		$this->forward('Plugin');
	}

	/**
	 * Uninstall plugin
	 */
	public function do_uninstall_plugin(){
		$class = $this->input->get('plugin');
		$instance = new $class;
		
		$instance->uninstall();
		
		$this->forward('Plugin');
	}
	
	/**
	 * Reinstall plugin
	 */
	public function do_reinstall_plugin(){
		$class = $this->input->get('plugin');
		$instance = new $class;
		
		$instance->uninstall();
		$instance->install();
		
		$this->forward('Plugin');
	}
}