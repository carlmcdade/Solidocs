<?php
/**
 * Plugins Management Controller
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Dynamic
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Dynamic_Controller_Admin_Plugins extends Solidocs_Controller_Action
{
	/**
	 * Index
	 */
	public function do_index(){
		$this->load->library('File');
		
		$db_plugins	= $this->db->select_from('plugin')->run()->arr('class');
		$plugins	= array();
		
		foreach($this->file->dir(PACKAGE) as $package){
			if($this->config->file_exists(PACKAGE . '/' . $package . '/Package')){
				$package_ini	= $this->config->load_file(PACKAGE . '/' . $package . '/Package', true);
				$from_config	= false;
				
				if(isset($package_ini['Plugin'])){
					foreach($package_ini['Plugin'] as $key => $val){
						$class = $package . '_Plugin_' . $key;
						
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
							'package'		=> $package,
							'name'			=> $val['name'],
							'description'	=> $val['description'],
							'autoload'		=> $autoload,
							'from_config'	=> $from_config
						);
					}
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