<?php
class Solidnode_Form_Edit extends Solidocs_Form
{
	/**
	 * Init
	 */
	public function init($content_type){
		$this->set_action($this->router->uri);
		$this->set_method('post');
		
		$this->add_element('title', array(
			'type' => 'text',
			'label' => 'Title',
			'helper' => array('form_text')
		));
		
		foreach($content_type as $name => $field){
			if(is_serialized($field['helper'])){
				$field['helper'] = unserialize($field['helper']);
			}
			else{
				$field['helper'] = array($field['helper']);
			}
			
			$element = array(
				'type' => $field['type'],
				'label' => $field['name'],
				'helper' => $field['helper']
			);
			
			if(is_serialized($field['validators'])){
				$element['validators'] = unserialize($field['validators']);
			}
			
			if(is_serialized($field['filters'])){
				$element['filters'] = unserialize($field['filters']);
			}
			
			$this->add_element('content[' . $name . ']', $element);
		}
		
		$this->add_element('published', array(
			'type' => 'bool',
			'label' => 'Publish',
			'helper' => array('form_select', array(0 => 'Not published', 1 => 'Published'))
		))->add_element('node_id', array(
			'type' => 'integer',
			'helper' => array('form_hidden')
		))->add_element('submit', array(
			'label' => 'Save',
			'type' => 'button',
			'helper' => array('form_button', 'Save changes')
		));
	}
}