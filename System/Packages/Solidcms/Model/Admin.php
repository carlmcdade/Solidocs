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
						'website'		=> '',
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
}