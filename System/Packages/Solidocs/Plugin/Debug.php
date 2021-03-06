<?php
/**
 * Debug Plugin
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Solidocs_Plugin_Debug extends Solidocs_Plugin
{
	/**
	 * Init
	 */
	public function init(){
		Solidocs::add_filter('render', array($this, 'debug_bar'));
		Solidocs::add_action('post_libraries', array($this, 'init_style'));
	}
	
	/**
	 * Init style
	 */
	public function init_style(){
		$this->theme->set_jquery(true);
		$this->theme->add_script('
		$(document).ready(function(){
		    
		    $("#debug_box ul li a").click(function(){
		    	
		    	if($(this).hasClass("active")){
		    		$(this).removeClass("active").siblings().hide();
		    	}
		    	else{
		    		$("#debug_box ul li a").removeClass("active").siblings().hide();
		    		$(this).addClass("active").siblings().show();
		    	}
		    });
		    
		    $("#debug_box ul li a.close").click(function(){
		    	
		    	$("#debug_box").remove();
		    	return false;
		    	
		    });
		    
		});
		');
		$this->theme->add_style('
		#debug_box
		{position: fixed; bottom: 0; left: 0; width: 100%; height: 25px; background: #444; border-top: 1px solid #333;}
		
		#debug_box ul
		{margin-left: 10px;}
		
		#debug_box ul li
		{display: inline; position: relative;}
		
		#debug_box ul li a
		{display: block; float: left; height: 25px; line-height: 25px; padding: 0 10px; font-size: 10px; background: #ccc; color: #222; border: 1px solid #666; border-top: 0; border-bottom: 0; margin-right: 10px;}
		
		#debug_box ul li div
		{position: absolute; bottom: 1px; left: 0; background: #ccc; border: 1px solid #666; border-bottom: 0; display: none; max-width: 900px; max-height: 600px; overflow: auto; font-size: 10px;}
		
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
		');
	}	
	
	/**
	 * Debug bar
	 */
	public function debug_bar($output){
		if(!$this->user->in_group('admin') AND APPLICATION_ENV !== 'development'){
			return $output;
		}
		
		if($this->output->get_type() !== 'html'){
			return $output;
		}
		
		$array = array(
			'General'	=> array(
				'Request URI'		=> $this->router->request_uri,
				'URI'				=> $this->router->uri,
				'Time to generate'	=> microtime_since(STARTTIME),
				'Memory usage'		=> round(memory_get_usage() / 1024 / 1024, 5) . ' MB',
				'Included files'	=> count(get_included_files()),
				'Database queries'	=> count($this->db->queries),
				'Locale'			=> $this->locale
			),
			'Hooks'				=> debug($this->hook, '', true),
			'Called hooks'		=> debug($this->called_hook, '', true),
			'Database queries'	=> debug($this->db->queries, '', true),
			'URI segments'		=> debug($this->router->segment, '', true),
			'Errors'			=> debug($this->errors, '', true),
			'ACL'				=> debug($this->acl->list, '', true),
			'Headers'			=> debug($this->output->headers, '', true),
			'$_REQUEST'			=> debug($_REQUEST, '', true),
			'$_GET'				=> debug($_GET, '', true),
			'$_POST'			=> debug($_POST, '', true),
			'$_FILES'			=> debug($_FILES, '', true),
			'$_SESSION'			=> debug($_SESSION, '', true),
			'$_COOKIE'			=> debug($_COOKIE, '', true)
		);

		$debug = '
		<div id="debug_box"><ul>';

		foreach($array as $section => $parts){
			$debug .= '<li>';
			
			if(!is_array($parts)){
				$debug .= '<div class="item">' . $parts . '</div>';
			}
			else{
				$debug .= '<div><table>';
				
				foreach($parts as $title => $content){
					$debug .= '<tr><td>' . $title . '</td><td>' . $content . '</td></tr>';
				}
				
				$debug .= '</table></div>';
			}
			
			$debug .= '<a href="#">' . $section . '</a></li>';
		}
		
		$debug .= '<li><a href="#" class="close">Close</a></li>';
		
		if(preg_match('/<\/body>/', $output, $matches)){
			$output = str_replace('</body>', $debug . '</body>', $output);
		}
		else{
			$output .= $debug;
		}
		
		return $output;
	}
}