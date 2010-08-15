<?php
/**
 * Menu Navigation
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Solidocs_Navigation_Menu extends Solidocs_Navigation_Navigation
{
	/**
	 * Defaults
	 */
	public $defaults = array(
		'before'			=> '',
		'after'				=> '',
		'before_children'	=> '<ul>',
		'after_children'	=> '</ul>',
		'before_item'		=> '<li>',
		'after_item'		=> '</li>',
		'before_active'		=> '<li class="active">',
		'after_active'		=> '</li>'
	);
	
	/**
	 * Render
	 *
	 * @param array
	 * @return string
	 */
	public function _render($args, $data){
		$output = '';
		
		foreach($data as $item){
			
			$before = 'before_item';
			$after = 'after_item';
			
			if($item['url'] == $this->active_url OR isset($item['children']) AND $this->has_active($item['children'])){
				$before = 'before_active';
				$after = 'after_active';
			}
			
			$output .= $this->args[$before] . '<a href="' . $item['url'] . '">' . $item['title'] . '</a>';
			
			if(isset($item['children'])){
				$output .= $this->args['before_children'] . $this->_render($this->args, $item['children']) . $this->args['after_children'];
			}
			
			$output .= $this->args[$after];
		}
		
		return $output;
	}
	
	/**
	 * Render
	 *
	 * @return string
	 */
	public function render(){
		return $this->args['before'] . $this->_render($this->args, $this->data) . $this->args['after'];
	}
}