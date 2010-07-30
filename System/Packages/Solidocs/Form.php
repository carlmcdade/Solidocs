<?php
class Solidocs_Form extends Solidocs_Base
{
	/**
	 * Action
	 */
	public $action = '#';
	
	/**
	 * Name
	 */
	public $name;
	
	/**
	 * Method
	 */
	public $method = 'get';
	
	/**
	 * Elements
	 */
	public $elements = array();
	
	/**
	 * Values
	 */
	public $values = array();
	
	/**
	 * To string
	 *
	 * @return string
	 */
	public function __toString(){
		return $this->render();
	}
	
	/**
	 * Set action
	 *
	 * @param string
	 */
	public function set_action($action){
		$this->action = $action;
	}
	
	/**
	 * Set name
	 *
	 * @param string
	 */
	public function set_name($name){
		$this->name = $name;
	}
	
	/**
	 * Set method
	 *
	 * @param string
	 */
	public function set_method($method){
		$this->method = $method;
	}
	
	/**
	 * Add element
	 *
	 * @param string
	 * @param array
	 */
	public function add_element($name, $element = array()){
		$element = array_merge(array(
			'type' => 'text',
			'required' => false
		), $element);
		
		$this->elements[$name] = $element;
	}
	
	/**
	 * Is posted
	 *
	 * @return bool
	 */
	public function is_posted(){
		return ($this->input->has_request());
	}
	
	/**
	 * Is valid
	 *
	 * @return bool
	 */
	public function is_valid(){
		foreach($this->elements as $name => $item){
			if(!$this->input->has_request($name) AND $item['required'] == true){
				return false;
			}
			
			$this->process_values();
			
			if(isset($item['validators'])){
				$this->load->library('Validator');
				
				foreach($item['validators'] as $validator => $params){
					array_unshift($params, $this->get_value($name));
					
					return $this->validator->validate($validator, $params);
				}
			}
		}
		
		return true;
	}
	
	/**
	 * Process values
	 */
	public function process_values(){
		foreach($this->elements as $name => $item){
			if($this->input->{'has_' . $this->method}($name)){
		    	$value = $this->input->{$this->method}($name);
		    	
		    	if(isset($item['filters'])){
		    		foreach($item['filters'] as $filter){
		    			$value = call_user_func($filter, $value);
		    		}
		    	}
		    	
		    	$this->values[$name] = $value;
		    }
		}
	}
	
	/**
	 * Get values
	 *
	 * @return array
	 */
	public function get_values(){
		if(!is_array($this->values)){
			$this->process_values();
		}
		
		return $this->values;
	}
	
	/**
	 * Get value
	 *
	 * @param string
	 */
	public function get_value($name){
		if(!is_array($this->values)){
			$this->process_values();
		}
		
		return $this->values[$name];
	}
	
	/**
	 * Render
	 *
	 * @return string
	 */
	public function render(){
		$output = $this->output->helper('form_starttag', array($this->action, $this->method, $this->name));
		
		foreach($this->elements as $name => $item){
			if(isset($item['label'])){
				$output .= $this->output->helper('form_label', $item['label']);
			}
			
			if(isset($item['helper'])){
				$params = $item['helper'];
				
				if(!is_array($params)){
					$helper = $params;
				}
				else{
					$helper = $params[0];
					unset($params[0]);
				}
				
				$value = '';
				if(isset($this->values[$name])){
					$value = $this->values[$name];
				}
				
				if($item['type'] !== 'button'){
					array_unshift($params, $value);
					array_unshift($params, $name);
				}
				
				$output .= $this->output->helper($helper, $params);
			}
		}
		
		return $output . $this->output->helper('form_endtag');
	}
}