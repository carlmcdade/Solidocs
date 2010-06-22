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
		$this->model->admin->get_installer($this->input->get('package'))->install();
		
		$this->redirect('/admin/package');
	}

	/**
	 * Uninstall package
	 */
	public function do_uninstall_package(){
		$this->model->admin->get_installer($this->input->get('package'))->uninstall();
		
		$this->redirect('/admin/package');
	}
	
	/**
	 * Reinstall package
	 */
	public function do_reinstall_package(){
		$installer = $this->model->admin->get_installer($this->input->get('package'));
		$installer->uninstall();
		$installer->install();
		
		$this->redirect('/admin/package');
	}
	
	/**
	 * Activate plugin
	 */
	public function do_activate_plugin(){
		$this->model->admin->activate_plugin($this->input->get('plugin'));
		
		$this->redirect('/admin/package/plugin');
	}

	/**
	 * Deactivate plugin
	 */
	public function do_deactivate_plugin(){
		$this->model->admin->deactivate_plugin($this->input->get('plugin'));
		
		$this->redirect('/admin/package/plugin');
	}
}