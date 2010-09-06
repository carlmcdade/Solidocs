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
class Dynamic_Plugin_Region extends Solidocs_Plugin
{
	/**
	 * Cache
	 */
	public $cache_regions = false;
	
	/**
	 * Cache region time
	 */
	public $cache_region_time = 1200;
	
	/**
	 * Init
	 */
	public function init(){
		Solidocs::add_action('pre_theme_render', array($this, 'populate_regions'));
	}
	
	/**
	 * Populate
	 *
	 * @param array
	 */
	public function _populate($item){
		$config = array();
		
		if(is_serialized($item['config'])){
			$config = unserialize($item['config']);
		}
		
		$this->theme->add_region_item($item['region'], new $item['widget']($config));
	}
	
	/**
	 * Populate regions
	 */
	public function populate_regions(){
		if($this->cache_regions){
			if($this->cache->exists('regions')){
				foreach($this->cache->get('regions') as $item){
					$this->_populate($item);
				}
				
				return true;
			}
		}
		
		$regions = $this->theme->layouts[$this->theme->layout]['regions'];
		
		$this->db->select_from('region_item')->where_in('region', $regions)->where(array(
			'locale' => $this->locale
		))->order('weight')->run();
		
		$items = $this->db->arr();
		
		if($this->cache_regions){
			$this->cache->store('regions', $items, $this->cache_region_time);
		}
		
		foreach($items as $item){
			$this->_populate($item);
		}
	}
}