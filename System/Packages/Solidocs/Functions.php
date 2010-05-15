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