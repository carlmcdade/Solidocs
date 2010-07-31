<?php
class Solidocs_Helper_Form extends Solidocs_Helper
{
	/**
	 * Starttag
	 *
	 * @param string	$action	Optional.
	 * @param string	$method	Optional.
	 * @param string	$name	Optional.
	 */
	public function starttag($action = '#', $method = 'post', $name = ''){
		return '<form action="' . $action . '" method="' . $method . '" name="' . $name . '">';
	}
	
	/**
	 * Endtag
	 *
	 * @return string
	 */
	public function endtag(){
		return '</form>';
	}
	
	/**
	 * Label
	 *
	 * @param string
	 * @param string	Optional.
	 * @return string
	 */
	public function label($label, $for = ''){
		if(!empty($for)){
			return '<label for="' . $for . '">' . $label . '</label>';
		}
		else{
			return '<label>' . $label . '</label>';
		}
	}
	
	/**
	 * Input
	 *
	 * @param string
	 * @param bool|string	Optional.
	 * @param string		Optional.
	 * @return string
	 */
	public function input($name, $value = false, $type = 'text'){
		if(is_bool($value) AND $value == true){
			$value = $value = $this->input->post($name, false);
		}
		elseif($value == false){
			$value = '';
		}
		
		return '<input type="' . $type . '" name="' . $name . '" value="' . $value . '" />';
	}
	
	/**
	 * Text
	 *
	 * @param string
	 * @param mixed		Optional.
	 * @return string
	 */
	public function text($name, $value = false){
		return $this->input($name, $value);
	}
	
	/**
	 * Password
	 *
	 * @param string
	 * @param mixed		Optional.
	 * @return string
	 */
	public function password($name, $value = false){
		return $this->input($name, $value, 'password');
	}
	
	/**
	 * Hidden
	 *
	 * @param string
	 * @param bool|string	Optional.
	 */
	public function hidden($name, $value = false){
		return $this->input($name, $value, 'hidden');
	}
	
	/**
	 * Select
	 *
	 * @param string
	 * @param array
	 * @param bool|string	Optional.
	 * @return string
	 */
	public function select($name, $value = false, $options = array()){
		if(is_bool($value) AND $value == true){
			$value = $value = $this->input->post($name, false);
		}
		elseif($value == false){
			$value = '';
		}
		
		$select = '<select name="' . $name . '">';
		
		foreach($options as $key => $val){
			$selected = '';
			
			if($value == $key){
				$selected = ' selected="selected"';
			}
			
			$select .= '<option value="' . $key . '"' . $selected . '>' . $val . '</option>';
		}
		
		return $select . '</select>';
	}
	
	/**
	 * Textarea
	 *
	 * @param string
	 * @param bool|string	Optional.
	 * @param integer		Optional.
	 * @param integer		Optional.
	 * @return string
	 */
	public function textarea($name, $value = false, $cols = 60, $rows = 15){
		if(is_bool($value) AND $value == true){
			$value = $value = $this->input->post($name, false);
		}
		elseif($value == false){
			$value = '';
		}
		
		return '<textarea name="' . $name . '" cols="' . $cols . '" rows="' . $rows . '">' . $value . '</textarea>';
	}
	
	/**
	 * Button
	 *
	 * @param string
	 * @param string	Optional.
	 */
	public function button($button, $type = 'submit'){
		return '<button type="' . $type . '">' . $button . '</button>';
	}
}