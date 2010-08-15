<?php
/**
 * Validator
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Solidocs_Validator extends Solidocs_Base
{
	/**
	 * Validate
	 *
	 * @param string
	 * @param array
	 */
	public function validate($validator, $params){
		if(in_array($validator, array('Strlen', 'Type'))){
			switch($validator){
				case 'Strlen':
					return call_user_func_array(array($this, 'strlen'), $params);
				break;
				case 'Type':
					return call_user_func_array(array($this, 'type'), $params);
				break;
			}
		}
		
		$library = $this->load->get_library('Validator_' . $validator);
		return $library->validate($params);
	}
	
	/**
	 * Strlen
	 *
	 * @param mixed
	 * @param integer
	 * @param integer
	 * @return bool
	 */
	public function strlen($value, $from, $to = 0){
		if(strlen($value) > $from){
			if($to !== 0 AND strlen($value) > $to){
				return false;
			}
			
			return true;
		}
		
		return false;
	}
	
	/** 
	 * Type
	 *
	 * @param array
	 * @return bool
	 */
	public function type($value, $params){
		switch($params[0]){
			case 'string':
				return (is_string($value));
			break;
			case 'integer':
				return (is_integer($value));
			break;
		}
		
		return true;
	}
}