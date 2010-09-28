<?php
/**
 * Feed Base Class
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php
 */
class Solidocs_Feed_Feed
{
	/**
	 * Title
	 */
	public $title;
	
	/**
	 * Link
	 */
	public $link;
	
	/**
	 * Description
	 */
	public $description;
	
	/**
	 * Items
	 */
	public $items = array();
	
	/**
	 * Set xml
	 */
	public function set_xml($xml){
	
	}
	
	/**
	 * Set title
	 *
	 * @param string
	 */
	public function set_title($title){
		$this->title = $title;
	}
	
	/**
	 * Set link
	 *
	 * @param string
	 */
	public function set_link($link){
		$this->link = $link;
	}
	
	/**
	 * Set description
	 *
	 * @param string
	 */
	public function set_description($description){
		$this->description = $description;
	}
	
	/**
	 * Set items
	 *
	 * @param array
	 */
	public function set_items($items){
		$this->items = $items;
	}
	
	/**
	 * Add item
	 *
	 * @param array
	 */
	public function add_item($item){
		$this->items[] = (object) $item;
	}
	
	/**
	 * Get items
	 *
	 * @return array
	 */
	public function get_items(){
		return $this->items;
	}
}