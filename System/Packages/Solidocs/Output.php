<?php
class Solidocs_Output extends Solidocs_Base
{
	/**
	 * View
	 */
	public $view = array();

	/**
	 * Headers
	 */
	public $headers = array(
		'Content-type: text/html; charset=utf-8'
	);
	
	/** 
	 * Render debug
	 */
	public $render_debug = false;
	
	/**
	 * Debug helper
	 */
	public $debug_helper = 'debug_bar';
	
	/**
	 * Call magic method
	 *
	 * @param string
	 * @param array
	 */
	public function __call($called, $params){
		$called = explode('_', $called);
		$method = $called[count($called) - 1];
		
		unset($called[count($called) - 1]);
		
		$helper = implode('_', $called);
		
		if(!isset($this->helper->$helper)){
			$this->load->helper($helper);
		}
		
		if(isset($this->helper->$helper)){
			return call_user_func_array(array($this->helper->$helper, $method), $params);
		}
	}
	
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
		foreach($this->headers as $header){
			header($header);
		}
		
		ob_start();
		
		if(is_object($this->theme) AND $this->theme->use_theme){
			$this->theme->render();
		}
		else{
			$this->render_content(false);
		}
		
		$output = ob_get_clean();
		
		if($this->render_debug == true){
			$output .= $this->{$this->debug_helper}();
		}
		
		echo $output;
	}
	
	/**
	 * Render content
	 *
	 * @param bool	Optional.
	 */
	public function render_content($render_layout = true){
		$views = '';
		
		foreach($this->view as $view){
			$views .= $view;
		}
		
		if($render_layout AND !empty($this->layout)){
			$this->theme_layout($this->layout, $views);
		}
		else{
			echo $views;
		}
	}
}