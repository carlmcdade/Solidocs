<?php
/**
 * Debug
 *
 * @param mixed
 * @param string	Optional.
 */
function debug($var, $label = null, $return = false){
	$str = '<pre><b>' . $label . '</b>' . str_replace(ROOT,'',print_r($var, true)) . '</pre>';
	
	if($return){
		return $str;
	}
	
	echo $str;
}

/**
 * Add action
 *
 * @param string
 * @param array
 */
function add_action($key, $hook){
	Solidocs::$registry->hook[$key][] = $hook;
}

/**
 * Do action
 *
 * @param string
 * @param array		Optional.
 */
function do_action($key, $data = null){
	if(!is_array($data)){
		$data = array($data);
	}
	
	foreach(Solidocs::$registry->hook[$key] as $hook){
		call_user_func_array($hook, $data);
	}
}

/**
 * Add filter
 *
 * @param string
 * @param array
 */
function add_filter($key, $hook){
	$this->add_action($key, $hook);
}

/**
 * Apply filter
 *
 * @param string
 * @param mixed
 */
function apply_filter($key, $data){
	if(!is_array($data)){
		$data = array($data);
	}
	
	foreach(Solidocs::$registry->hook[$key] as $hook){
		$data = call_user_func_array($hook, $data);
	}
	
	return $data;
}

/**
 * Parse args
 *
 * @param array
 * @param array|string
 * @return array
 */
function parse_args($defaults, $args){
	if(!is_array($args)){
		parse_str($args, $args);
	}
	
	return array_merge($defaults, $args);
}

/**
 * Microtime since
 *
 * @param double
 * @return float
 */
function microtime_since($start)
{
	$start	= explode(' ',$start);
	$stop	= explode(' ',microtime());
	
	return round(($stop[0] + $stop[1]) - ($start[1] + $start[0]), 6);
}

/**
 * Is Serialized
 * Check if data is serialized or not 
 * 
 * @param mixed $data    variable to check 
 * @return boolean 
 */
function is_serialized($string)
{
	$string = trim($string);
	
	if(!is_array($string) AND !empty($string) AND preg_match('/^(i|s|a|o|d)(.*);/si', $string)){
		return true;
	}
	
	return false;
}

/**
 * Excerpt
 *
 * @param string
 * @param integer
 * @return string
 */
function excerpt($text, $maxchars) {
	$text		= substr($text, 0, $maxchars);
	$position	= strrpos($text, ' ');
	
	if($position > 0){
		$text = substr($text, 0, $position);
	}
	
    return $text;
}