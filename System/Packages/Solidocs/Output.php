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
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			
			$("#debug_box ul li a").click(function(){
				
				$("#debug_box ul li div").hide();
				$(this).siblings().show();
				
			});
			
		});
		</script>
		<style type="text/css">
		#debug_box
		{position: fixed; bottom: 0; left: 0; width: 100%; height: 25px; background: #444; border-top: 1px solid #333;}
		
		#debug_box ul
		{margin-left: 10px;}
		
		#debug_box ul li
		{display: inline; position: relative;}
		
		#debug_box ul li a
		{display: block; float: left; height: 25px; line-height: 25px; padding: 0 10px; font-size: 10px; background: #ccc; color: #444; border: 1px solid #666; border-top: 0; border-bottom: 0; margin-right: 10px;}
		
		#debug_box ul li div
		{position: absolute; bottom: 1px; left: 0; background: #ccc; border: 1px solid #666; border-bottom: 0; display: none;}
		
		#debug_box ul li div.item
		{padding: 5px;}
		
		#debug_box ul li div table
		{width: 500px;}
		
		#debug_box ul li div table tr td
		{padding: 5px;}
		
		#debug_box ul li div table tr td:first-child
		{font-weight: bold; padding-right: 20px;}
		
		#debug_box ul li div table tr:nth-child(even) td
		{background: #ddd;}
		</style>
		<div id="debug_box"><ul>';

		foreach($debug as $section => $parts){
			$output .= '<li>';
			
			if(!is_array($parts)){
				$output .= '<div class="item">' . $parts . '</div>';
			}
			else{
				$output .= '<div><table>';
				
				foreach($parts as $title => $content){
					$output .= '<tr><td>' . $title . '</td><td>' . $content . '</td></tr>';
				}
				
				$output .= '</table></div>';
			}
			
			$output .= '<a href="#">' . $section . '</a></li>';
		}
		
		return $output . '<li><a href="#">X</a></ul></div>';
	}
}