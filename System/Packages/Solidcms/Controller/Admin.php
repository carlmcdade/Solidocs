<?php
class Solidcms_Controller_Admin extends Solidocs_Controller_Action
{
	/**
	 * Init
	 */
	public function init(){
		$this->acl->set_access($this, 'index', 3, 'login');
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
		$this->theme->set_theme('Admin');
	}
	
	/**
	 * Item
	 */
	public function do_item(){
	}
}