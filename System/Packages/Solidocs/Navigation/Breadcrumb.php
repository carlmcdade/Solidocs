<?php
class Solidocs_Navigation_Breadcrumb extends Solidocs_Navigation_Navigation
{
	/**
	 * Defaults
	 */
	public $defaults = array(
		'before'			=> '',
		'after'				=> '',
		'before_item'		=> '<li>',
		'after_item'		=> '</li>'
	);
	
	/**
	 * Render
	 *
	 * @param array
	 */
	public function _render($args, $data){
		$output = '';
		
		foreach($data as $item){
			if($this->is_active($item) OR isset($item['children']) AND $this->has_active($item['children'])){
				$output .= $args['before_item'] . '<a href="' . $item['url'] . '">' . $item['title'] . '</a>' . $args['after_item'];
				
				if(isset($item['children'])){
					$output .= $this->_render($args, $item['children']);
				}
			}
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