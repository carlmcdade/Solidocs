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
}