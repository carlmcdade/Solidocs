<?php
/**
 * Region Plugin
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class Node_Plugin_Region extends Solidocs_Plugin
{
	/**
	 * Init
	 */
	public function init(){
		Solidocs::add_action('pre_theme_render', array($this, 'populate_regions'));
	}
	
	/**
	 * Populate regions
	 */
	public function populate_regions(){
		$regions = $this->theme->layouts[$this->theme->layout]['regions'];
		
		$this->db->select_from('region_item')->where_in('region', $regions)->order('weight')->run();
		
		while($item = $this->db->fetch_assoc()){
			$config = array();
			
			if(is_serialized($item['config'])){
				$config = unserialize($item['config']);
			}
			
			$this->theme->add_region_item($item['region'], new $item['widget']($config));
		}
	}
}