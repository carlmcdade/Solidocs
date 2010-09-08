<?php
/**
 * Extended Form Helper
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Solidocs_Helper_Xform extends Solidocs_Helper
{
	/**
	 * Item list
	 *
	 * @param string
	 * @param array|bool
	 */
	public function item_list($name, $values = false, $extra = 5){
		if(is_array($values)){
			foreach($values as $value){
				$output .= $this->output->helper('form')->text($name . '[]', $value) . '<br />';
			}
		}
		
		for($i = 1; $i <= $extra; $i++){
			$output .= $this->output->helper('form')->text($name . '[]') . '<br />';
		}
		
		return $output;
	}
	
	/**
	 * Select bool
	 *
	 * @param string
	 * @param value
	 */
	public function select_bool($name, $value = false){
		return $this->output->helper('form')->select($name, $value, array('false', 'true'), false);
	}
}