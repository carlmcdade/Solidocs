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
		
		$element['type'] = $type;
		
		$this->elements[$name] = $element;
	}
	
	/**
	 * Is posted
	 *
	 * @return bool
	 */
	public function is_posted(){
		return ($this->input->{'has_' . $this->method}());
	}
	
	/**
	 * Is valid
	 *
	 * @return bool
	 */
	public function is_valid(){
		foreach($this->elements as $name => $item){
			if(!$this->input->{'has_' . $this->method}($name) AND $item['required'] == true){
				return false;
			}
			
			if(isset($item['validators'])){
				/**
				 * Validators
				 */	
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
		if(count($this->values) == 0){
			$this->process_values();
		}
		
		return $this->values;
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
				$helper = $params[0];
				unset($params[0]);
				
				if(isset($this->values[$name])){
					array_unshift($params, $this->values[$name]);
				}
				
				array_unshift($params, $name);
				
				debug($params);
				
				$output .= $this->output->helper($helper, $params);
			}
		}
		
		return $output . $this->output->helper('form_endtag');
	}
}