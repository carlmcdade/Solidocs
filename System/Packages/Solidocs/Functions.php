<?php
/**
 * Debug
 *
 * @param mixed
 * @param string	Optional.
 */
function debug($var, $label = null){
	echo '<pre><b>' . $label . '</b>' . str_replace(ROOT,'',print_r($var, true)) . '</pre>';
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