<?php
class Solidocs_Theme extends Solidocs_Base
{
	/**
	 * Use theme
	 */
	public $use_theme = true;
	
	/**
	 * Theme
	 */
	public $theme = 'Default';
	
	/**
	 * Theme file
	 */
	public $theme_file = 'index.php';
	
	/**
	 * Theme layout
	 */
	public $theme_layout;
	
	/**
	 * Title base
	 */
	public $title_base = null;
	
	/**
	 * Title parts
	 */
	public $title_parts = array();
	
	/**
	 * Title separator
	 */
	public $title_separator = ' - ';
	
	/**
	 * Title base after
	 */
	public $title_base_after = false;
	
	/**
	 * Render
	 */
	public function render(){
		define('THEME', MEDIA . '/Theme/' . $this->theme);
		define('THEME_WWW', str_replace(ROOT, '', THEME));
		
		include(THEME . '/' . $this->theme_file);
	}
	
	/**
	 * Render content
	 *
	 * @param bool
	 */
	public function render_content($render_layout = true){
		$this->output->render_content($render_layout);
	}
	
	/**
	 * Theme layout
	 *
	 * @param string
	 * @param string
	 */
	public function theme_layout($layout, $views){
		include(THEME . '/' . $layout . '.layout.php');
	}
	
	/**
	 * Theme part
	 *
	 * @param string
	 */
	public function theme_part($part){
		include(THEME . '/' . $part . '.php');
	}
	
	/**
	 * Title
	 *
	 * @param string		Optional.
	 * @param string|array	Optional.
	 * @param string		Optional.
	 * @param bool			Optional.
	 * @return string
	 */
	public function title($title_base = null, $title_parts = null, $title_separator = ' - ', $title_base_after = false){
		if($this->title_base !== null){
			$title_base = $this->title_base;
		}
		
		if(count($this->title_parts) !== 0){
			$title_parts = $this->title_parts;
		}
		
		if(!is_array($title_parts)){
			if(!empty($title_parts)){
				$title_parts = array($title_parts);
			}
			else{
				$title_parts = array();
			}
		}
		
		if($this->title_separator == null){
			$title_separator = $this->title_separator;
		}		
		
		if($this->title_base_after == false AND $title_base_after == false){
			array_unshift($title_parts, $title_base);
		}
		else{
			$title_parts[] = $title_base;
		}
		
		return implode($title_separator, $title_parts);		
	}
}