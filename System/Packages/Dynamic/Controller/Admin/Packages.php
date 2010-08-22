<?php
class Dynamic_Controller_Admin_Packages extends Solidocs_Controller_Action
{
	/**
	 * Init
	 */
	public function init(){
		$this->load->library('File');
	}
	
	/**
	 * Do index
	 */
	public function do_index(){
		$packages = array();
		
		foreach($this->file->dir(PACKAGE) as $package){
			if($this->config->file_exists(PACKAGE . '/' . $package . '/Package')){
				$packages[$package] = $this->config->load_file(PACKAGE . '/' . $package . '/Package', true);
			}
			else{
				$packages[$package] = array(
					'name' => $package,
					'version' => 0,
					'url' => '',
					'description' => ''
				);
			}
		}

		$this->load->view('Admin_Packages', array(
			'packages' => $packages
		));
	}
	
	/**
	 * Install
	 */
	public function do_install(){
		$package = $this->input->uri_segment('id');
		
		if(file_exists(PACKAGE . '/' . $package . '/Model/Package.php')){
			$this->load->model('Package', $package);
			
			if(method_exists($this->model->package, 'install')){
				$this->model->package->install();
			}
		}
		
		$this->forward('index');
	}
	
	/**
	 * Uninstall
	 */
	public function do_uninstall(){
		$package = $this->input->uri_segment('id');
		
		if(file_exists(PACKAGE . '/' . $package . '/Model/Package.php')){
			$this->load->model('Package', $package);
			
			if(method_exists($this->model->package, 'uninstall')){
				$this->model->package->uninstall();
			}
		}
		
		$this->forward('index');
	}
	
	/**
	 * Reinstall
	 */
	public function do_reinstall(){
		$package = $this->input->uri_segment('id');
		
		if(file_exists(PACKAGE . '/' . $package . '/Model/Package.php')){
			$this->load->model('Package', $package);
			
			if(method_exists($this->model->package, 'uninstall')){
				$this->model->package->uninstall();
			
				if(method_exists($this->model->package, 'install')){
					$this->model->package->install();
				}
			}
		}
		
		$this->forward('index');
	}
}