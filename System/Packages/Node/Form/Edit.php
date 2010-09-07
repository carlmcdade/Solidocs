<?php
/**
 * Node Content Editing Form
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Node
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Node_Form_Edit extends Solidocs_Form
{
	/**
	 * Init
	 */
	public function init($content_type){
		$this->load->model('Theme');
		
		$layouts = array();
		
		foreach($this->model->theme->get_layouts() as $key => $layout){
			$layouts[$key] = $layout['name'];
		}
		
		$this->set_action($this->router->request_uri);
		$this->set_method('post');
		$this->set_data_form(true);
		
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
			'helper' => array('form/text')
		))->add_element('uri', array(
			'type' => 'text',
			'label' => 'URI',
			'helper' => array('form/text')
		))->add_element('locale', array(
			'type' => 'text',
			'label' => 'Locale',
			'helper' => array('form/select', $locales)
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
		
		$this->add_element('tags', array(
			'type' => 'text',
			'label' => 'Tags',
			'helper' => array('form/text')
		))->add_element('description', array(
			'type' => 'text',
			'label' => 'Description',
			'helper' => array('form/text')
		))->add_element('view', array(
			'type' => 'text',
			'label' => 'View',
			'helper' => array('form/text')
		))->add_element('layout', array(
			'type' => 'text',
			'label' => 'Layout',
			'helper' => array('form/select', $layouts)
		))->add_element('view', array(
			'type' => 'text',
			'label' => 'View',
			'helper' => array('form/text')
		))->add_element('published', array(
			'type' => 'bool',
			'label' => 'Publish',
			'helper' => array('form/select', array(0 => 'Not published', 1 => 'Published'), false)
		))->add_element('node_id', array(
			'type' => 'integer',
			'helper' => array('form/hidden')
		))->add_element('submit', array(
			'label' => 'Save',
			'type' => 'button',
			'helper' => array('form/button', 'Save changes')
		));
	}
}