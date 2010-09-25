<?php
/**
 * What You See Is What You Get (WYSIWYG) Editor Helper
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		CKEditor
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class CKEditor_Helper_Ckeditor extends Solidocs_Helper
{
	/**
	 * Ckeditor
	 *
	 * @param string
	 * @param string|bool
	 * @param integer		Optional.
	 * @param integer		Optional.
	 * @return
	 */
	public function ckeditor($name, $value = false, $width = 500, $height = 200){
		if(is_bool($value) AND $value == true){
			$value = $value = $this->input->post($name, false);
		}
		elseif($value == false){
			$value = '';
		}
		
		$cols = 80;
		$rows = 40;
		
		// Add the necessary files to the theme
		$this->theme->set_jquery(true);
		$this->theme->add_css(PACKAGE . '/CKEditor/Media/sample.css');
		$this->theme->add_js(PACKAGE . '/CKEditor/Media/ckeditor.js');
		$this->theme->add_js(PACKAGE . '/CKEditor/Media/sample.js');
		#$this->theme->add_script('
		#$(document).ready(function(){
		#	cleditor(".' . $class . '", {width:' . $width . ', height:' . $height . '});
        #});
		#');
		
		// Render the textarea
		return '<textarea class="ckeditor" name="' . $name . '" cols="' . $cols . '" rows="' . $rows . '">' . stripslashes($value) . '</textarea>';
	}
}