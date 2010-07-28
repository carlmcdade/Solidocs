<?php
class Application_Form_Login extends Solidocs_Form
{
	/**
	 * Init
	 */
	public function init(){
		$this->set_name('login');
		$this->set_method('post');
		$this->set_action($this->router->request_uri);
		$this->add_element('email', array(
			'type' => 'text',
			'filters' => array('trim'),
			'validators' => array(
				'Strlen' => array(
					0,
					50
				)
			),
			'required' => true,
			'label' => 'E-mail',
			'helper' => array('form_text')
		));
		$this->add_element('password', array(
			'type' => 'password',
			'filters' => array('trim'),
			'validators' => array(
				'Strlen' => array(
					6,
					50
				)
			),
			'required' => true,
			'label' => 'Password',
			'helper' => array('form_input', 'password')
		));
		$this->add_element('submit', array(
			'type' => 'button',
			'helper' => array('form_button', 'Submit')
		));
	}
}