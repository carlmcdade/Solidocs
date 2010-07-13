<?php
class Solidocs_Helper_Form extends Solidocs_Helper
{
	/**
	 * Label
	 *
	 * @param string
	 * @param string	Optional.
	 */
	public function label($label, $for = ''){
		if(!empty($for)){
			echo '<label for="' . $for . '">' . $label . '</label>';
		}
		else{
			echo '<label>' . $label . '</label>';
		}
	}
	
	/**
	 * Input
	 *
	 * @param string
	 * @param bool|string	Optional.
	 * @param string		Optional.
	 */
	public function input($name, $value = false, $type = 'text'){
		if(is_bool($value) AND $value == true){
			$value = $value = $this->input->post($name, false);
		}
		elseif($value == false){
			$value = '';
		}
		
		echo '<input type="' . $type . '" name="' . $name . '" value="' . $value . '" />';
	}
	
	/**
	 * Select
	 *
	 * @param string
	 * @param array
	 * @param bool|string	Optional.
	 */
	public function select($name, $options, $value = false){
		if(is_bool($value) AND $value == true){
			$value = $value = $this->input->post($name, false);
		}
		elseif($value == false){
			$value = '';
		}
		
		echo '<select name="' . $name . '">';
		
		foreach($options as $key => $val){
			$selected = '';
			
			if($value == $key){
				$selected = ' selected="selected"';
			}
			
			echo '<option value="' . $key . '"' . $selected . '>' . $val . '</option>';
		}
		
		echo '</select>';
	}
	
	/**
	 * Textarea
	 *
	 * @param string
	 * @param bool|string	Optional.
	 * @param integer		Optional.
	 * @param integer		Optional.
	 */
	public function textarea($name, $value = false, $cols = 15, $rows = 20){
		if(is_bool($value) AND $value == true){
			$value = $value = $this->input->post($name, false);
		}
		elseif($value == false){
			$value = '';
		}
		
		echo '<textarea name="' . $name . '" cols="' . $cols . '" rows="' . $rows . '">' . $value . '</textarea>';
	}
	
	/**
	 * Button
	 *
	 * @param string
	 * @param string	Optional.
	 */
	public function button($button, $type = 'submit'){
		echo '<button type="' . $type . '">' . $button . '</button>';
	}
}