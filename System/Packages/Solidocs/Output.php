<?php
/**
 * Output
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Solidocs_Output extends Solidocs_Base
{
	/**
	 * View
	 */
	public $view = array();
	
	/**
	 * Rendered views
	 */
	public $rendered_views = null;
	
	/**
	 * Type
	 */
	public $type = 'html';
	
	/**
	 * Data
	 */
	public $data = array();
	
	/**
	 * Headers
	 */
	public $headers = array();
	
	/**
	 * Use theme
	 */
	public $use_theme = true;
	
	/**
	 * Messages
	 */
	public $messages = array();
	
	/**
	 * Init
	 */
	public function init(){
		if(isset($this->session->messages)){
			foreach($this->session->messages as $message){
				$this->add_message($message['type'], $message['headline'], $message['text']);
			}
		}
		
		unset($this->session->messages);
	}
	
	/**
	 * Call magic method
	 *
	 * @param string
	 * @param array
	 */
	public function __call($method, $params){
		return $this->helper($method, $params);
	}
	
	/**
	 * Helper
	 *
	 * @param string
	 * @param array
	 */
	public function helper($method, $params){
		if(!is_array($params) AND !empty($params)){
			$params = array($params);
		}
		
		$helper = explode('/', strtolower($method));
		
		if(isset($helper[1])){
			$method = $helper[1];
		}
		
		$helper = $helper[0];
		
		// Load helper if it isn't loaded
		if(!isset($this->helper->$helper)){
			$this->load->helper($helper);
		}
		
		// Check for method
		if(method_exists($this->helper->$helper, $method)){
			return call_user_func_array(array($this->helper->$helper, $method), $params);
		}
		else{
			return $this->helper->$helper;
		}
		
		return false;
	}
	
	/**
	 * Set type
	 *
	 * @param string
	 */
	public function set_type($type){
		$this->type = $type;
	}
	
	/**
	 * Get type
	 *
	 * @return string
	 */
	public function get_type(){
		return $this->type;
	}
	
	/**
	 * Set data
	 *
	 * @param array
	 */
	public function set_data($data){
		$this->data = $data;
	}
	
	/**
	 * Get data
	 *
	 * @return array
	 */
	public function get_data($data){
		return $this->data;
	}
	
	/**
	 * Set header
	 *
	 * @param string
	 */
	public function set_header($header){
		$this->headers[] = $header;
	}
	
	/**
	 * Get headers
	 *
	 * @return array
	 */
	public function get_headers(){
		return $this->headers;
	}
	
	/**
	 * Set use theme
	 *
	 * @param bool
	 */
	public function set_use_theme($flag){
		$this->use_theme = $flag;
	}
	
	/**
	 * Use theme
	 *
	 * @return bool
	 */
	public function use_theme(){
		return $this->use_theme;
	}
	
	/**
	 * Add flash message
	 *
	 * @param string
	 * @param string	Optional.
	 * @param string	Optional.
	 */
	public function add_flash_message($type, $headline = '', $text = ''){
		if(empty($headline)){
			$headline = $type;
			$type = 'info';
		}
		
		if(!isset($this->session->messages)){
			$this->session->messages = array();
		}
		
		$messages = (array) $this->session->messages;
		
		$messages[] = array(
			'type' 		=> $type,
			'headline'	=> $headline,
			'text'		=> $text
		);
		
		$this->session->messages = $messages;
	}
	
	/**
	 * Add message
	 *
	 * @param string
	 * @param string	Optional.
	 * @param string	Optional.
	 */
	public function add_message($type, $headline = '', $text = ''){
		if(empty($headline)){
			$headline = $type;
			$type = 'info';
		}
		
		$this->messages[] = array(
			'type' 		=> $type,
			'headline'	=> $headline,
			'text'		=> $text
		);
	}
	
	/**
	 * Get messages
	 *
	 * @return array
	 */
	public function get_messages(){
		return $this->messages;
	}
	
	/**
	 * Add view
	 *
	 * @param string
	 * @param array		Optional.
	 */
	public function add_view($file, $params = null){
		$this->view[] = array(
			'file' => $file,
			'params' => $params
		);
	}
	
	/**
	 * Is rendered
	 *
	 * @return bool
	 */
	public function is_rendered(){
		return (!is_null($this->rendered_views));
	}
	
	/**
	 * Render view
	 *
	 * @param string
	 */
	public function render_view($file, $params = null){
		ob_start();
		
		if(is_object($params)){
			$params = (array) $params;
		}
		
		if(is_array($params)){
			extract($params);
		}
		
		include($file);
		
		return $this->parse_markup(ob_get_clean(), $params);
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
		
		return str_replace($search, $replace, $output);
	}
	
	/**
	 * Render
	 */
	public function render(){
		// Prepare for each type
		switch($this->get_type()){
			case 'html':
				$this->set_header('Content-type: text/html; charset=utf-8');
			break;
			
			case 'json':
				$this->set_header('Content-type: application/json; charset=utf-8');
				$this->set_use_theme(false);
			break;
			
			case 'xml':
				$this->set_header('Content-type: text/xml; charset=utf-8');
				$this->set_use_theme(false);
			break;
			
			case 'serialized':
				$this->set_header('Content-type: text/plain; charset=utf-8');
				$this->set_use_theme(false);
			break;
		}
		
		// Check for headers
		if(headers_sent()){
			throw new Exception('Headers have already been sent');
		}
		else{
			// Set headers
			foreach($this->get_headers() as $header){
				header($header);
			}
		}
		
		// Command line
		if(COMMAND_LINE){
			die('Command line');
		}
		
		ob_start();
		
		// The rendering
		if(is_object($this->theme) AND $this->use_theme()){
			$this->theme->prepare();
			$this->render_content(true);
			
			echo $this->theme->render();
		}
		elseif($this->get_type() !== 'html'){
			echo $this->render_data($this->get_type(), $this->get_data());
		}
		else{
			echo $this->render_content();
		}
		
		// Return the output
		return ob_get_clean();
	}
	
	/**
	 * Render messages
	 */
	public function render_messages(){
		$output = '';
		
		foreach($this->messages as $message){
			if($this->message_view !== null){
				$output .= $this->load->get_view($this->message_view, $message);
			}
			else{
				$output .= '
					<div class="message ' . $message['type'] . '">
						<span>' . $message['headline'] . '</span>
				';
				
				if(!empty($message['text'])){
					$output .= '
					<p>' . $message['text'] . '</p>
					';
				}
						
				$output .= '
				</div>
				';
			}
		}
		
		return $output;
	}
	
	/**
	 * Render content
	 *
	 * @return string
	 */
	public function render_content($return = false){
		if($this->is_rendered()){
			return $this->rendered_views;
		}
		
		$views = '';
		
		if(count($this->messages) !== 0){
			$views .= $this->render_messages();
		}
		
		foreach($this->view as $view){
			$views .= $this->render_view($view['file'], $view['params']);
		}
		
		$this->rendered_views = $views;
		
		if($return){
			return $this->rendered_views;
		}
		
		echo $this->rendered_views;
	}
	
	/**
	 * Render data
	 *
	 * @param string
	 * @param array|null
	 */
	public function render_data($type, $data){
		if($type == 'json'){
			echo json_encode($data);
		}
		elseif($type == 'serialized'){
			echo serialize($data);
		}
		elseif($type == 'xml'){
			$xml = new Solidocs_Xml($data);
			echo $xml->render();
		}
	}
}