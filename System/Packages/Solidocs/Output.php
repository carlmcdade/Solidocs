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
	 * Debug box
	 */
	public $debug_box = false;
	
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
		
		if($this->debug_box){
			$output .= $this->render_debug();
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
	
	/**
	 * Render debug
	 *
	 * @return string
	 */
	public function render_debug(){
		$debug = array(
			'General'	=> array(
				'Time to generate'	=> microtime_since(STARTTIME),
				'Memory usage'		=> round(memory_get_usage() / 1024 / 1024, 5) . ' MB',
				'Included files'	=> count(get_included_files())
			),
			'Database queries'	=> debug($this->db->instance->queries, '', true),
			'Errors'			=> debug($this->error->errors, '', true),
			'ACL'				=> debug($this->acl->list, '', true),
			'$_GET'				=> debug($_GET, '', true),
			'$_POST'			=> debug($_POST, '', true),
			'$_FILES'			=> debug($_FILES, '', true),
			'$_SESSION'			=> debug($_SESSION, '', true),
			'$_COOKIE'			=> debug($_COOKIE, '', true)
		);
		
		$output = '
		<style type="text/css">
		#debug_box
		{background: #fff; border: 2px solid #444; border-left: 0; border-right: 0; padding: 10px 0 0 0; margin: 10px 0; font-size: 10px;}
		
		#debug_box .section
		{background: #eee; margin-bottom: 10px;}
		
		#debug_box .section .headline
		{display: block; padding: 5px; font-weight: bold; border: 1px solid #ccc; border-left: 0; border-right: 0; background: #ddd;}
		
		#debug_box .section .item
		{padding: 5px; border-bottom: 1px solid #ccc;}
		
		#debug_box .section .row div
		{padding: 5px; border-bottom: 1px solid #ccc;}
		
		#debug_box .section .row div:first-child
		{float: left; width: 200px; font-weight: bold;}
		</style>
		<div id="debug_box">';
		
		foreach($debug as $section => $parts){
			$output .= '<div class="section"><span class="headline">' . $section . '</span>';
			
			if(!is_array($parts)){
				$output .= '<div class="item">' . $parts . '</div>';
			}
			else{
				foreach($parts as $title => $content){
					$output .= '<div class="row"><div>' . $title . '</div><div>' . $content . '</div></div>';
				}
			}
			
			$output .= '</div>';
		}
		
		return $output . '</div>';
	}
}