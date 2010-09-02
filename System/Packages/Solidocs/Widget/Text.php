<?php
/**
 * Text widget
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class Solidocs_Widget_Text extends Solidocs_Widget
{
	/**
	 * Content
	 */
	public $content;
	
	/**
	 * Fields
	 */
	public $fields = array(
		'title', 'content'
	);
	
	/**
	 * Render
	 */
	public function render(){
		return $this->content;
	}
}