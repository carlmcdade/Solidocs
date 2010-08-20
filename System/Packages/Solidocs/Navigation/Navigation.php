<?php
/**
 * Abstract Navigation Base
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
abstract class Solidocs_Navigation_Navigation
{
	/**
	 * Data
	 */
	public $data;
	
	/**
	 * Args
	 */
	public $args;
	
	/**
	 * Defaults
	 */
	public $defaults;
	
	/**
	 * Active url
	 */
	public $active_url;
	
	/**
	 * Constructor
	 *
	 * @param array
	 * @param string|array
	 * @param string
	 */
	public function __construct($data = '', $args = '', $active_url = ''){
		$this->set_data($data);
		$this->set_args($args);
		$this->set_active_url($active_url);
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
	 * Set args
	 *
	 * @param array
	 */
	public function set_args($args){
		$this->args = parse_args($this->defaults, $args);
	}
	
	/**
	 * Set active url
	 *
	 * @param string
	 */
	public function set_active_url($url){
		$this->active_url = $url;
	}
	
	/**
	 * Is active
	 *
	 * @param array
	 * @return bool
	 */
	public function is_active($item){
		return ($item['url'] == $this->active_url);
	}
	
	/**
	 * Has active
	 *
	 * @param array
	 * @return bool
	 */
	public function has_active($data){
		foreach($data as $item){
			if($this->is_active($item)){
				return true;
			}
			
			if(isset($item['children'])){
				if($this->has_active($item['children']) == true){
					return true;
				}
			}
		}
		
		return false;
	}
}