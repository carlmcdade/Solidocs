<?php
class Solidocs_Navigation_Navigation
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
	public function __construct($data, $args, $active_url = ''){
		$this->data = $data;
		$this->args = parse_args($this->defaults, $args);
		$this->active_url = $active_url;
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