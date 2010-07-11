<?php
class Solidocs_Helper_Form extends Solidocs_Helper
{
	/**
	 * Label
	 *
	 * @param string
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
	 * @param array|string
	 * @param bool			Optional.
	 */
	public function input($args, $auto_value = false){
		$args = parse_args(array(
			'type' => 'text'
		), $args);
		
		if($auto_value AND isset($args['name'])){
			$value = $this->input->post($args['name'], false);
			
			if($value !== false){
				$args['value'] = $value;
			}
		}
		
		echo '<input ' . html_properties($args) . ' />';
	}
	
	/**
	 * Select
	 *
	 * @param array|string
	 * @param array
	 * @param bool|string	Optional.
	 */
	public function select($args, $options, $value = false){
		$args = parse_args(array(
		), $args);
		
		if(is_bool($value)){
			$value = $this->input->post($args['name'], false);
		}
		
		echo '<select ' . html_properties($args) . '>';
		
		foreach($options as $key => $val){
			echo '<option value="' . $key . '">' . $val . '</option>';
		}
		
		echo '</select>';
	}
	
	/**
	 * Button
	 *
	 * @param array|string
	 */
	public function button($button, $args = false){
		$args = parse_args(array(
			'type'	=> 'submit'
		), $args);
		
		echo '<button ' . html_properties($args) . '>' . $button . '</button>';
	}
	
	/**
	 * Textarea
	 *
	 * @param array|string
	 * @param bool
	 */
	public function textarea($args, $value = '', $auto_value = false){
		$args = parse_args(array(
			'cols'	=> 30,
			'rows'	=> 5
		),$args);
		
		if($auto_value){
			if($this->input->post($args['name'], false) !== false){
				$value = $this->input->post($args['name']);
			}
		}
		
		echo '<textarea ' . html_properties($args) . '>' . $value . '</textarea>';
	}
}