<?php
class Solidcms_Controller_Admin_Package extends Solidocs_Controller_Action
{
	/**
	 * Index
	 */
	public function do_index(){
		$this->load->view('Admin_Packages', array(
			'list' => $this->model->admin->get_packages()
		));
	}
	
	/**
	 * Plugin
	 */
	public function do_plugin(){
		$this->load->view('Admin_Plugins', array(
			'list' => $this->model->admin->get_plugins(),
			'active_plugins' => $this->model->admin->get_active_plugins(),
			'config_plugins' => $this->model->admin->get_config_plugins()
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
	 * Activate plugin
	 */
	public function do_activate_plugin(){
		$this->model->admin->activate_plugin($this->input->get('plugin'));
		
		$this->forward('Plugin');
	}

	/**
	 * Deactivate plugin
	 */
	public function do_deactivate_plugin(){
		$this->model->admin->deactivate_plugin($this->input->get('plugin'));
		
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