<?php
/**
 * Table Helper
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php
 */
class Solidocs_Helper_Table extends Solidocs_Helper
{
	/**
	 * Thead
	 */
	public function thead($fields, $args = null){
		// Args
		$args = parse_args(array(
			'sort_fields'	=> '',
			'sort_key'		=> 'sort',
			'order_key'		=> 'order',
			'default_order'	=> 'ASC'
		), $args);
		
		$content		= '';
		$current_sort	= '';
		$current_order	= '';
		
		// Current sort and order
		if($this->input->has_get($args['sort_key'])){
			$current_sort	= $this->input->get($args['sort_key']);
			$current_order	= $this->input->get($args['order_key']);
		}
		
		// Loop fields
		foreach($fields as $key => $field){
			// Check if sort and order should be applied
			if(is_array($args['sort_fields']) AND in_array($key, $args['sort_fields'])){
				$order = $args['default_order'];
				
				// Order
				if($current_sort == $key){
					if($current_order == 'ASC'){
						$order = 'DESC';
					}
					else{
						$order = 'ASC';
					}
				}
				
				// New field content
				$field = '<a href="' . $this->router->uri . '?' . $args['sort_key'] . '=' . $key . '&order=' . $order . '">' . $field . '</a>';
			}
			
			// Add field
			$content .= '<th>' . $field . '</th>';
		}
		
		// Display
		return $content;
	}
}