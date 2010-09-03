<?php
/**
 * Admin Controller
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Admin
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Admin_Controller_Admin extends Solidocs_Controller_Action
{
	/**
	 * Init
	 */
	public function init(){
		$this->acl->set_access($this, 'init', 'admin');
		$this->acl->set_access($this, 'index', 'admin', array('route', 'login', array(
			'redirect' => $this->router->request_uri
		)));
				
		if(!$this->acl->has_access($this, 'init')){
			$this->output->add_flash_message('error', 'Please sign in to access this page.');
		}
	}
	
	/**
	 * Index
	 */
	public function do_index(){
		$this->load->model('Admin');
		$this->theme->add_title('Admin');
		
		$item = $this->model->admin->get_item($this->input->uri_segment('item'));
		
		if(!is_array($item)){
			throw new Exception('Could not find admin item', 404);
		}
		
		$controller = $this->load->controller($item['controller']);
		$controller->dispatch_action($this->input->uri_segment('action'));
		
		$this->theme->set_theme('Admin');
	}
}