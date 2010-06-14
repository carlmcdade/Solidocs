<?php
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
}