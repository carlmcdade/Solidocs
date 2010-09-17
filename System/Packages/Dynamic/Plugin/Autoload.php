<?php
/**
 * Autoload Plugin
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Dynamic
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Dynamic_Plugin_Autoload extends Solidocs_Plugin
{
	/**
	 * Load config
	 */
	public $load_config = true;
	
	/** 
	 * Load plugins
	 */
	public $load_plugins = true;
	
	/**
	 * Load acl
	 */
	public $load_acl = true;
	
	/**
	 * Init
	 */
	public function init(){
		if($this->load_config){
			Solidocs::add_action('pre_libraries', array($this, 'init_config'));
		}
		
		if($this->load_plugins){
			Solidocs::add_action('pre_libraries', array($this, 'init_plugins'));
		}
		
		if($this->load_acl){
			Solidocs::add_action('pre_libraries', array($this, 'init_acl'));
		}
	}
	
	/**
	 * Init config
	 */
	public function init_config(){
		$this->db->select_from('config')->run();
		
		if($this->db->affected_rows() !== 0){
			$array = array();
			
			foreach($this->db->arr() as $item){
				$array[$item['key']] = $item['value'];
			}
			
			$this->config->add_array($array);
		}
	}
	
	/**
	 * Init plugins
	 */
	public function init_plugins(){
		$this->db->select_from('plugin')->where(array(
			'autoload' => true
		))->run();
		
		if($this->db->affected_rows() !== 0){
			foreach($this->db->arr() as $item){
				$this->load->plugin($item['class']);
			}
		}
	}
	
	/**
	 * Init acl
	 */
	public function init_acl(){
		$this->db->select_from('acl')->run();
		
		if($this->db->affected_rows()){
			while($item = $this->db->fetch_assoc()){
				$this->acl->list[$this->_key($item['category'], $item['key'])] = array(
					'group'		=> $item['group'],
					'action'	=> $item['action']
				);
			}
		}
	}
}