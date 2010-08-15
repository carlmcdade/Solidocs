<?php
/**
 * XML
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Solidocs_Xml
{
	/**
	 * Data
	 */
	public $data = array();
	
	/**
	 * Starttag
	 */
	public $starttag = true;
	
	/**
	 * Constructor
	 */
	public function __construct($data = array()){
		$this->set_data($data);
	}
	
	/**
	 * Set data
	 *
	 * @param array
	 */
	public function set_data($data){
		$this->data = $data;
	}
	
	/**
	 * _Render
	 *
	 * @param array
	 * @return string
	 */
	public function _render($data){
		$xml = '';
		
		foreach($data as $key => $val){
			if(is_array($val)){
				$xml .= '<' . $key . '>' . $this->_render($val) . '</' . $key . '>';
			}
			else{
				$xml .= '<' . $key . '>' . $val . '</' . $key . '>';
			}
		}
		
		return $xml;
	}
	
	/**
	 * Render
	 *
	 * @return string
	 */
	public function render(){
		$xml = '';
		
		if($this->starttag){
			$xml .= '<?xml version="1.0" encoding="UTF-8"?>';
		}
		
		$xml .= $this->_render($this->data);
		
		return $xml;
	}
}