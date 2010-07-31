<?php
class Solidyn_Controller_Admin_Plugins extends Solidocs_Controller_Action
{
	/**
	 * Index
	 */
	public function do_index(){
		$this->load->library('File');
		
		$db_plugins = $this->db->select_from('plugin')->run()->arr('class');
		
		$plugins = array();
		
		foreach($this->file->dir(PACKAGE) as $package){
			if(file_exists(PACKAGE . '/' . $package . '/Plugin')){
				foreach($this->file->dir(PACKAGE . '/' . $package . '/Plugin') as $plugin){
					include(PACKAGE . '/' . $package . '/Plugin');
					$class = $package . '_Plugin_' . trim($plugin, '.php');
					$from_config = false;
					
					if(!isset($db_plugins[$class])){
						$this->db->insert_into('plugin', array(
							'class' => $class,
							'autoload' => false
						))->run();
						
						$autoload = false;
					}
					else{
						$autoload = $db_plugins[$class]['autoload'];
					}
					
					if(in_array($class, $this->config->get('Autoload.plugins'))){
						$from_config = true;
					}
					
					$plugins[$class] = array(
						'package' => $package,
						'name' => $class::$name,
						'description' => $class::$description,
						'autoload' => $autoload,
						'from_config' => $from_config
					);
				}
			}
		}

		$this->load->view('Admin_Plugins', array(
			'plugins' => $plugins
		));
	}
	
	/**
	 * Activate
	 */
	public function do_activate(){
		$this->db->update_set('plugin', array(
			'autoload' => true
		))->where(array(
			'class' => $this->input->uri_segment('id')
		))->run();
		
		$this->redirect('/admin/plugins');
	}
	
	/**
	 * Deactivate
	 */
	public function do_deactivate(){
		$this->db->update_set('plugin', array(
			'autoload' => false
		))->where(array(
			'class' => $this->input->uri_segment('id')
		))->run();
		
		$this->redirect('/admin/plugins');
	}
}