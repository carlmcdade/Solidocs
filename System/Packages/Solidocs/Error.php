<?php
class Solidocs_Error
{
	/**
	 * Display
	 */
	public $display = false;
	
	/**
	 * Errors
	 */
	public $errors = array();
	
	/**
	 * Constructor
	 */
	public function __construct(){
		set_error_handler(array($this, 'error_handler'));
	}
	
	/**
	 * Error
	 *
	 * @param integer
	 * @param string
	 * @param string
	 * @param integer
	 */
	public function error_handler($errno, $errstr, $errfile, $errline){
		$errno		= $this->error_level($errno);
		$errstr		= str_replace(ROOT, '', $errstr);
		$errfile	= str_replace(ROOT, '', $errfile);
		
		if($this->display){
			echo '<div style="padding: 10px; margin: 10px; border:1px solid red;"><b>' . $errno . ':</b> ' . $errstr . ' in <b>' . $errfile . '</b> on line <b> ' . $errline . '</b></div>';
		}
		
		$this->errors[] = array(
			'errno'		=> $errno,
			'errstr'	=> $errstr,
			'errfile'	=> $errfile,
			'errline'	=> $errline
		);
	}
	
	/**
	 * Error level
	 *
	 * @param integer
	 */
	public function error_level($errno){
		switch($errno){
			case E_NOTICE:
			case E_USER_NOTICE:
				return 'Notice';
			break;
			
			default:
				return 'Error';
			break;
		}
	}
}