<?php
/**
 * Content Model
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Node
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Node_Model_Content extends Solidocs_Base
{
	/**
	 * Get views
	 *
	 * @param string
	 * @param string	Optional.
	 * @param array		Optional.
	 * @return array
	 */
	public function _get_views($folder, $before = '', $exclude_folders = array()){
		$views = array();
		
		foreach($this->file->dir($folder) as $file){
			if(is_dir($folder . '/' . $file)){
				if(!in_array($file, $exclude_folders)){
					$views = array_merge($views, $this->_get_views($folder . '/' . $file, $before . $file . '_', $exclude_folders));
				}
			}
			else{
				$views[] = $before . substr($file, 0, -4);
			}
		}
		
		return $views;
	}
	
	/**
	 * Get views
	 *
	 * @return array
	 */
	public function get_views($exclude_folders = array()){
		$this->load->library('File');
		
		$views = $this->_get_views(APP . '/View', '', $exclude_folders);
		
		foreach($this->file->dir(PACKAGE) as $package){
			if(file_exists(PACKAGE . '/' . $package . '/View')){
				$views = array_merge($views, $this->_get_views(PACKAGE . '/' . $package . '/View', '', $exclude_folders));
			}
		}
		
		sort($views);
		
		$new_views = array();
		
		foreach($views as $view){
			$new_views[$view] = $view;
		}
		
		return $new_views;
	}
}