<?php
class Solidcms_Model_Admin extends Solidocs_Base
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
	 * Get packages
	 *
	 * @return array
	 */
	public function get_packages(){
		$packages = array();
		
		$handle = opendir(PACKAGE);
		
		while(false !== ($package = readdir($handle))){
			if($package !== '.' AND $package !== '..'){
				$path = PACKAGE . '/' . $package;
				
				if(file_exists($path . '/Package.ini')){
					$item = parse_ini_file($path . '/Package.ini');
				}
				else{
					$item = array(
						'name' 			=> $package,
						'version'		=> 'unknown',
						'url'			=> '',
						'description'	=> ''
					);
				}
				
				$item['package'] = $package;
				
				if(file_exists($path . '/Model/Install.php')){
					$item['install'] = true;
				}
				else{
					$item['install'] = false;
				}
				
				$packages[] = $item;
			}
		}
		
		closedir($handle);
		
		return $packages;
	}
	
	/**
	 * Get plugins
	 *
	 * @return array
	 */
	public function get_plugins(){
		$plugins = array();
		
		$handle = opendir(PACKAGE);
		
		while(false !== ($package = readdir($handle))){
			if($package !== '.' AND $package !== '..'){
				$path = PACKAGE . '/' . $package . '/Plugin';
				
				if(file_exists($path)){
					
					$package_handle = opendir($path);
					
					while(false !== ($plugin = readdir($package_handle))){
						if($plugin !== '.' AND $plugin !== '..'){
							$class = $package . '_Plugin_' . trim($plugin, '.php');
							
							include_once($path . '/' . $plugin);
							
							$instance = new $class;
							
							$plugins[] = array(
								'name'			=> $instance->name,
								'description'	=> $instance->description,
								'version'		=> $instance->version,
								'url'			=> $instance->url,
								'class'			=> $class
							);
						}
					}
					
					closedir($package_handle);
				}
			}
		}
		
		closedir($handle);
		
		return $plugins;
	}
}