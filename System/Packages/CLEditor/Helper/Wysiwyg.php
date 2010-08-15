<?php
/**
 * What You See Is What You Get (WYSIWYG) Editor Helper
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class CLEditor_Helper_Wysiwyg extends Solidocs_Helper
{
	/**
	 * Wysiwyg
	 *
	 * @param string
	 * @param string|bool
	 * @param integer		Optional.
	 * @param integer		Optional.
	 * @return
	 */
	public function wysiwyg($name, $value = false, $width = 500, $height = 200){
		if(is_bool($value) AND $value == true){
			$value = $value = $this->input->post($name, false);
		}
		elseif($value == false){
			$value = '';
		}
		
		// Add the necessary files to the theme
		$this->theme->set_jquery(true);
		$this->theme->add_css(PACKAGE . '/CLEditor/Media/jquery.cleditor.css');
		$this->theme->add_js(PACKAGE . '/CLEditor/Media/jquery.cleditor.js');
		$this->theme->add_script('
		$(document).ready(function(){
			cleditor("#wysiwyg", {width:' . $width . ', height:' . $height . '});
        });
		');
		
		// Render the textarea
		return '<textarea id="wysiwyg" name="' . $name . '" cols="' . $cols . '" rows="' . $rows . '">' . $value . '</textarea>';
	}
}