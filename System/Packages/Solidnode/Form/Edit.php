<?php
class Solidnode_Form_Edit extends Solidocs_Form
{
	/**
	 * Init
	 */
	public function init($content_type){
		$this->set_action($this->router->request_uri);
		$this->set_method('post');
		
		if(count($this->i18n->locales) == 0){
			$locales[$this->i18n->default_locale] = $this->i18n->default_locale;
		}
		else{
			$locales = array();
			
			foreach($this->i18n->locales as $locale){
				$locales[$locale] = $locale;
			}
		}
		
		$this->add_element('title', array(
			'type' => 'text',
			'label' => 'Title',
			'helper' => array('form_text')
		))->add_element('uri', array(
			'type' => 'text',
			'label' => 'URI',
			'helper' => array('form_text')
		))->add_element('locale', array(
			'type' => 'text',
			'label' => 'Locale',
			'helper' => array('form_select', $locales)
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
		
		$this->add_element('view', array(
			'type' => 'text',
			'label' => 'View',
			'helper' => array('form_text')
		))->add_element('published', array(
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