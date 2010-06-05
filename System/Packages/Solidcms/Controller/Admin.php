<?php
class Solidcms_Controller_Admin extends Solidocs_Controller_Action
{
	public function init(){
		$this->set_access('index', 3, '404');
	}
	
	public function do_index(){
		$this->theme->set_theme('Admin');
	}
}