<?php
class Solidocs_Plugin_Db extends Solidocs_Plugin
{
	/**
	 * Name
	 */
	public $name = 'Database';
	
	/**
	 * Description
	 */
	public $description = 'A plugin which enables configuration and plugin loading from the database.';
	
	/**
	 * Init
	 */
	public function init(){
		Solidocs::add_action('post_libraries', array($this, 'init_config'));
		Solidocs::add_action('post_libraries', array($this, 'init_plugins'));
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
}