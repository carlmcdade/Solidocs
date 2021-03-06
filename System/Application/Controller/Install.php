<?php
/**
 * Application Install Controller
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Application_Controller_Install extends Solidocs_Controller_Action
{
	/**
	 * Init
	 */
	public function init(){
		$this->theme->set_theme('Plain');
	}
	
	/**
	 * Index
	 */
	public function do_index(){
		$packages = array(
			'Solidocs',
			'Admin',
			'Node',
			'Dynamic',
			'Media',
			'CKEditor'
		);
			
		if($this->input->has_get('uninstall')){
			foreach($packages as $package){
				$model = $this->load->get_model('Package', $package);
				
				$model->uninstall();
			}
		}
		
		if($this->input->has_get('install')){
			foreach($packages as $package){
				$model = $this->load->get_model('Package', $package);
				
				$model->uninstall();
				$model->install();
			}
			
			$this->output->add_message('success', 'The packages were successfully installed');
			$this->output->add_message('error', 'Security is compromised', 'Please remove Application_Controller_Install, Application_View_Install and the [install] route from Routes.ini');
		}
		
		$this->load->view('Install');
	}
}