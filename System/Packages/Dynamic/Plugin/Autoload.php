<?php
class Dynamic_Plugin_Autoload extends Solidocs_Plugin
{
	/**
	 * Name
	 */
	public static $name = 'Autoload';
	
	/**
	 * Description
	 */
	public static $description = 'Autoloads plugins, config and ACL from the database.';
	
	/**
	 * Init
	 */
	public function init(){
		Solidocs::add_action('post_libraries', array($this, 'init_config'));
		Solidocs::add_action('post_libraries', array($this, 'init_plugins'));
		Solidocs::add_action('post_libraries', array($this, 'init_acl'));
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