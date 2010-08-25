<?php
/**
 * Application Error Controller
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Application_Controller_Error extends Solidocs_Controller_Action
{
	/**
	 * 404
	 */
	public function do_404(){
		$this->output->set_header('HTTP/1.1 404 Not Found');
		$this->load->view('404');
	}
	
	/**
	 * 500
	 */
	public function do_500(){
		$this->load->view('500');
	}
}