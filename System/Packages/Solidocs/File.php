<?php
/**
 * File
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Solidocs_File
{
	/**
	 * Dir
	 *
	 * @param string
	 * @return array
	 */
	public function dir($path){
		$files	= array();
		$handle	= opendir($path);
		
		while(false !== ($file = readdir($handle))){
			if($file !== '.' AND $file !== '..'){
				$files[] = $file;
			}
		}
		
		closedir($handle);
		
		return $files;
	}
	
	/**
	 * Get contents
	 *
	 * @param string
	 */
	public function get_contents($file){
		return file_get_contents($file);
	}
	
	/**
	 * Set contents
	 *
	 * @param string
	 * @param string
	 */
	public function set_contents($file, $contents){
		$handler = fopen($file, 'w');
		fwrite($handler, $contents);
		fclose($handler);
	}
	
	/**
	 * Delete
	 *
	 * @param string
	 */
	public function delete($file){
		unlink($file);
	}
	
	/**
	 * Mkdir
	 *
	 * @param string
	 * @param integer	Optional.
	 */
	public function mkdir($path, $mode = 0777){
		if(!mkdir($path, $mode, true)){
			throw new Exception('Could not make directory "' . $path . '"');
		}
		
		$this->chmod($path, $mode);
	}
	
	/**
	 * Chmod
	 *
	 * @param integer
	 */
	public function chmod($file, $mode){
		chmod($file, $mode);
	}
}