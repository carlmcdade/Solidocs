<?php
/**
 * Application Index Controller
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Application_Controller_Index extends Solidocs_Controller_Action
{
	/**
	 * Index
	 */
	public function do_index(){
		$this->load->view('Index');
	}
	
	/**
	 * About
	 */
	public function do_about(){
		$this->load->view('About');
	}
}