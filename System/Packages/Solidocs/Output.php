<?php
class Solidocs_Output extends Solidocs_Base
{
	/**
	 * View
	 */
	public $view = array();
	
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
	 * Add view
	 *
	 * @param string
	 * @param array		Optional.
	 */
	public function add_view($file, $params = null){
		ob_start();
		
		if(is_array($params)){
			extract($params);
		}
		
		include($file);
		
		$this->view[] = $this->parse_markup(ob_get_clean(), $params);
	}
	
	/**
	 * Parse markup
	 *
	 * @param string
	 * @param array
	 */
	public function parse_markup($output, $params){
		if(!is_array($params)){
			return $output;
		}
		
		$search		= array();
		$replace	= array();
		
		foreach($params as $key=>$val){
			if(!is_array($val)){
				$search[]	= '{'.$key.'}';
				$replace[]	= $val;
			}
		}
		
		return str_replace($search,$replace,$output);
	}
	
	/**
	 * Render
	 */
	public function render(){
		$views = '';
		
		foreach($this->view as $view){
			$views .= $view;
		}
		
		if($this->use_theme){
			define('THEME', MEDIA . '/Theme/' . $this->theme);
			define('THEME_WWW', str_replace(ROOT, '', THEME));
			
			include(THEME . '/' . $this->theme_file);
		}
	}
	
	/**
	 * Theme part
	 *
	 * @param string
	 */
	public function theme_part($part){
		include(THEME . '/' . $part . '.php');
	}
}