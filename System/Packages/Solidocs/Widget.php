<?php
/**
 * Widget
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class Solidocs_Widget extends Solidocs_Base
{
	/**
	 * Before widget
	 */
	public $before_widget;
	
	/**
	 * After widget
	 */
	public $after_widget;
	
	/**
	 * Before title
	 */
	public $before_title;
	
	/**
	 * After title
	 */
	public $after_title;
	
	/**
	 * Title
	 */
	public $title;
	
	/** 
	 * Fields
	 */
	public $fields = array(
		'title'
	);
	
	/** 
	 * Constructor
	 */
	public function __construct($config){
		if(!is_array($config)){
			$config = array();
		}
		
		$config = array_merge(array(
			'before_widget'	=> '<li>',
			'after_widget'	=> '</li>',
			'before_title'	=> '<h3>',
			'after_title'	=> '</h3>',
			'title'			=> ''
		), $config);
		
		parent::__construct($config);
	}
	
	/**
	 * toString
	 *
	 * @return string
	 */
	public function __toString(){
		$output = $this->before_widget;
		
		if(!empty($this->title)){
			$output .= $this->before_title . $this->title . $this->after_title;
		}
		
		return $output . $this->render() . $this->after_widget;
	}
	
	/**
	 * Render
	 *
	 * @return string
	 */
	public function render(){
		return 'empty widget';
	}
}