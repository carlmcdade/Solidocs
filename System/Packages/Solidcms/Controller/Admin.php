<?php
class Solidcms_Controller_Admin extends Solidocs_Controller_Action
{
	/**
	 * Init
	 */
	public function init(){
		$this->acl->set_access($this, 'index', 'admin', 'login');
		$this->acl->set_access($this, 'item', 'admin', 'login');
		
		if($this->model->user->in_group('admin')){
			$this->load->model('Admin');
			$this->theme->set_theme('Admin');	
		}
	}
	
	/**
	 * Login
	 */
	public function do_login(){
		if($this->input->post('username', false) !== false){
			if($this->model->user->auth($this->input->post('username'), $this->input->post('password'))){
				$this->redirect('/admin');
			}
		}
		
		$this->theme->add_title_part('Login');
		$this->theme->add_theme_file('login');
		$this->load->view('Login');
	}
	
	/**
	 * Logout
	 */
	public function do_logout(){
		$this->session->destroy();
		$this->redirect('/');
	}
	
	/**
	 * Index
	 */
	public function do_index(){
		$item	= $this->input->uri_segment('item');
		$action	= $this->input->uri_segment('action');
		$admin	= $this->model->admin->get_item($item);
		
		if($admin == false){
			$admin['controller']	= 'Admin_' . ucfirst($item);
			$admin['package']		= 'Solidcms';
		}
		
		$class	= $this->load->controller($admin['controller'], $admin['package']);
		
		if(empty($class)){
			throw new Exception('The item "' . $item . '" could not be found', 404);
			return false;
		}
		
		$controller = new $class;
		$controller->dispatch_action($action);
	}
}