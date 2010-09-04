<?php
/**
 * Theme Model
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Admin
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class Admin_Model_Theme extends Solidocs_Base
{
	/**
	 * Get regions
	 */
	public function get_regions(){
		$theme_ini = $this->config->load_file(MEDIA . '/Theme/' . $this->theme->theme . '/theme', true);
		
		return $theme_ini['regions'];
	}
	
	/**
	 * Get region items
	 *
	 * @param string
	 * @param string	Optional.
	 * @return array
	 */
	public function get_region_items($region, $locale = null){
		if($locale == null){
			$locale = $this->locale;
		}
		
		$this->db->select_from('region_item')->where(array(
			'region'	=> $region,
			'locale'	=> $locale
		))->order('weight')->run();
		
		return $this->db->arr();
	}
	
	/**
	 * Get region item
	 *
	 * @param integer
	 * @return array
	 */
	public function get_region_item($region_item_id){
		$this->db->select_from('region_item')->where(array(
			'region_item_id' => $region_item_id
		))->run();
		
		return $this->db->fetch_assoc();
	}
	
	/**
	 * Get widgets
	 *
	 * @return array
	 */
	public function get_widgets(){
		$this->db->select_from('widget')->run();
		
		return $this->db->arr();
	}
	
	/**
	 * Get widget
	 *
	 * @param string
	 */
	public function get_widget($widget){
		$this->db->select_from('widget')->where(array(
			'widget' => $widget
		))->run();
		
		return $this->db->fetch_assoc();
	}
	
	/**
	 * Add widget
	 *
	 * @param string
	 * @param string
	 * @param array
	 * @param array
	 */
	public function add_widget($region, $locale, $widget, $config = null){
		if($config == null){
			$default_config = $this->get_widget($widget['widget']);
			$default_config = $default_config['default_config'];
			
			$config = $default_config;
		}
		else{
			$config = serialize($config);
		}
		
		$data = $widget;
		$data['region'] = $region;
		$data['config'] = $config;
		$data['locale'] = $locale;
		
		$this->db->insert_into('region_item', $data)->run();
	}
	
	/**
	 * Update widget
	 *
	 * @param integer
	 * @param array
	 */
	public function update_widget($region_item_id, $widget){
		$data = array();
		
		if(isset($widget['weight'])){
			$data['weight'] = $widget['weight'];
			
			unset($widget['weight']);
		}
		
		$data['config'] = serialize($widget);
		
		$this->db->update_set('region_item', $data)->where(array(
			'region_item_id' => $region_item_id
		))->run();
	}
	
	/**
	 * Delete region item
	 *
	 * @param integer
	 */
	public function delete_region_item($region_item_id){
		$this->db->delete_from('region_item')->where(array(
			'region_item_id' => $region_item_id
		))->run();
	}
}