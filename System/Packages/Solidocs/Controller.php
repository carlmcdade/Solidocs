<?php
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