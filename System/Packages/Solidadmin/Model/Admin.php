<?php
class Solidadmin_Model_Admin extends Solidocs_Base
{
	/**
	 * Get item
	 *
	 * @param string
	 * @return array
	 */
	public function get_item($item){
		$this->db->select_from('admin')->where(array('item' => $item))->run();
		
		return $this->db->fetch_assoc();
	}
	
	/**
	 * Get package info
	 *
	 * @param string
	 * @return array
	 */
	public function get_package_info($package){
		$path = PACKAGE . '/' . $package;
		
		$info = array(
			'name' 			=> $package,
			'version'		=> 'unknown',
			'url'			=> '',
			'description'	=> '',
			'package'		=> $package
		);
		
		if(file_exists($path . '/Package.ini')){
		    $info = array_merge($info, parse_ini_file($path . '/Package.ini'));
		}
		
		return $info;
	}
	
	/**
	 * Get packages
	 *
	 * @return array
	 */
	public function get_packages(){
		$this->load->library('File');
		$packages = array();
		
		foreach($this->file->dir(PACKAGE) as $package){
			$item = $this->get_package_info($package);
			$item['install'] = false;
			
			if(file_exists(PACKAGE . '/' . $package . '/Model/Install.php')){
			    $item['install'] = true;
			}
			
			$packages[] = $item;
		}	
		
		return $packages;
	}
	
	/**
	 * Get plugins
	 *
	 * @return array
	 */
	public function get_plugins(){
		$this->load->library('File');
		$plugins = array();
		
		foreach($this->file->dir(PACKAGE) as $package){
			$path = PACKAGE . '/' . $package . '/Plugin';
			
			if(file_exists($path)){
				$info = $this->get_package_info($package);
				
				foreach($this->file->dir($path) as $plugin){
				    $class = $package . '_Plugin_' . trim($plugin, '.php');
				    
				    include_once($path . '/' . $plugin);
				    
				    $instance = new $class;
				    
				    $plugins[] = array(
				        'name'			=> $instance->name,
				        'description'	=> $instance->description,
				        'class'			=> $class,
				        'package'		=> $info['package'],
				        'version'		=> $info['version'],
				        'url'			=> $info['url']
				    );
				}
			}
		}
		
		return $plugins;
	}
}