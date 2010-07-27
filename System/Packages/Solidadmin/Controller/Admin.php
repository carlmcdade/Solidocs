<?php
class Solidadmin_Controller_Admin extends Solidocs_Controller_Action
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
	 * Index
	 */
	public function do_index(){
		$item = $this->model->admin->get_item($this->input->uri_segment('item'));
		
		if(!is_array($item)){
			throw new Exception('Could not find admin item', 404);
		}
		
		$controller = $this->load->controller($item['controller']);
		$controller->dispatch_action($this->input->uri_segment('action'));
	}
}