<?php
class Solidocs_Output extends Solidocs_Base
{
	/**
	 * View
	 */
	public $view = array();
	
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
		
		return str_replace($search, $replace, $output);
	}
	
	/**
	 * Render
	 */
	public function render(){
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
		
		if(headers_sent()){
			throw new Exception('Headers have already been sent');
		}
		else{
			foreach($this->headers as $header){
				header($header);
			}
		}
		
		ob_start();
		
		if(is_object($this->theme) AND $this->use_theme()){
			echo $this->theme->render();
		}
		elseif($this->get_type() !== 'html'){
			echo $this->render_data($this->get_type(), $this->get_data());
		}
		else{
			echo $this->render_content();
		}
		
		return ob_get_clean();
	}
	
	/**
	 * Render content
	 *
	 * @return string
	 */
	public function render_content($return = false){
		$views = '';
		
		foreach($this->view as $view){
			$views .= $view;
		}
		
		if($return){
			return $views;
		}
		
		echo $views;
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