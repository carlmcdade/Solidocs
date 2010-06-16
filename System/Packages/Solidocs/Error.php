<?php
class Solidocs_Error
{
	/**
	 * Errors
	 */
	public $errors = array();
	
	/**
	 * Backtrace
	 */
	public $backtrace = true;
	
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
	public function error_handler($errno, $string, $file, $line){
		$string		= str_replace(ROOT, '', strip_tags($string));
		$file		= str_replace(ROOT, '', $file);
		$backtrace	= array();
		
		if($this->backtrace){
			foreach(debug_backtrace() as $i => $item){
				unset($item['object']);
				unset($item['args']);
				
				if($i !== 0){
					$backtrace[] = $item;
				}
			}
		}
		
		$this->errors[] = array(
			'errno'		=> $errno,
			'string'	=> $string,
			'file'		=> $file,
			'line'		=> $line,
			'backtrace'	=> $backtrace
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