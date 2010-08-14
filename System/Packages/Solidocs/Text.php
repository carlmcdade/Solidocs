<?php
class Solidocs_Text
{
	/**
	 * Encoding
	 */
	public $encoding = 'UTF-8';
	
	/** 
	 * Excerpt
	 *
	 * @param string
	 * @param integer
	 */
	public function excerpt($str, $maxchars, $after = '...'){
		$str		= mb_substr($str, 0, $maxchars - strlen($after), $this->encoding);
		$position	= mb_strrpos($str, ' ', $this->encoding);
		
		if($position > 0){
			$str = mb_substr($str, 0, $position, $this->encoding);
		}
		
    	return $str . $after;
	}
	
	/**
	 * Slug
	 *
	 * @param string
	 * @param array		Optional.
	 */
	public function slug($str, $maxchars = 100, $params = array()){
		$params = array(
			' ' => '_',
			'.' => '',
			'?' => '',
			'!' => '',
			'%' => '',
			'#' => '',
			'"' => '',
			'\'' => '',
			'+' => '',
			'@' => '',
			'$' => '',
			'€' => '',
			'=' => '',
			'å' => 'a',
			'ä' => 'a',
			'ö' => 'o',
			'é' => 'e',
			'è' => 'e'
		);
		
		$search = array();
		$replace = array();
		
		foreach($params as $key => $val){
			$search[] = $key;
			$replace[] = $val;
		}
		
		return str_replace($search, $replace, mb_strtolower(mb_substr($str, 0, $maxchars, $this->encoding), $this->encoding));
	}
}