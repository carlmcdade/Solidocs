<?php
/**
 * Controller
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Solidocs_Controller extends Solidocs_Base
{
	/**
	 * Redirect
	 *
	 * @param string
	 */
	public function redirect($url){
		header('location:' . $url);
	}
	
	/**
	 * Refresh
	 */
	public function refresh(){
		$this->redirect('http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
	}
}