<?php
class Solidocs_Helper_Debug extends Solidocs_Helper
{
	/**
	 * Debug bar
	 *
	 * @return string
	 */
	public function bar(){
		$debug = array(
			'General'	=> array(
				'Time to generate'	=> microtime_since(STARTTIME),
				'Memory usage'		=> round(memory_get_usage() / 1024 / 1024, 5) . ' MB',
				'Included files'	=> count(get_included_files())
			),
			'Database queries'	=> debug($this->db->instance->queries, '', true),
			'Errors'			=> debug($this->error->errors, '', true),
			'ACL'				=> debug($this->acl->list, '', true),
			'$_REQUEST'			=> debug($_REQUEST, '', true),
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
		{display: block; float: left; height: 25px; line-height: 25px; padding: 0 10px; font-size: 10px; background: #ccc; color: #222; border: 1px solid #666; border-top: 0; border-bottom: 0; margin-right: 10px;}
		
		#debug_box ul li div
		{position: absolute; bottom: 1px; left: 0; background: #ccc; border: 1px solid #666; border-bottom: 0; display: none; max-width: 900px; max-height: 600px; overflow: auto;}
		
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