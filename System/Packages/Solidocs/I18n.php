<?php
/**
 * Internationalization
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php
 */
class Solidocs_I18n extends Solidocs_Base
{
	/**
	 * Date format
	 */
	public $date_format = 'Y-m-d';
	
	/**
	 * Time format
	 */
	public $time_format = 'H:i:s';
	
	/**
	 * Timezone
	 */
	public $timezone = 'Europe/London';
	
	/**
	 * Accepted locales
	 */
	public $accepted_locales = array('en_GB');
	
	/**
	 * Locales
	 */
	public $locales = array();
	
	/**
	 * Default locale
	 */
	public $default_locale = 'en_GB';
	
	/**
	 * Auto localize
	 */
	public $auto_localize = true;
	
	/**
	 * Strings
	 */
	public $strings = array();
	
	/**
	 * Autoload strings
	 */
	public $autoload_strings = true;
	
	/**
	 * Init
	 */
	public function init(){
		if(!is_array($this->accepted_locales)){
			$this->accepted_locales = explode(',', $this->accepted_locales);
		}
		
		if($this->auto_localize){
			if($this->input->get('lang', false) !== false){
				$locale = $this->input->get('lang');
			}
			elseif(isset($this->session->locale)){
				$locale = $this->session->locale;
			}
			elseif(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
				$lang = explode('-',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
				$locale = $lang[0].'_'.strtoupper($lang[1]);
			}
			
			if(isset($locale) AND in_array($locale,$this->accepted_locales)){
				return $this->set_locale($locale);
			}
		}
		
		$this->set_locale($this->default_locale);
	}
	
	/**
	 * Set locale
	 *
	 * @param string
	 */
	public function set_locale($locale){
		if(strlen($locale) !== 5 OR !in_array($locale, $this->locales) AND $locale !== $this->default_locale){
			return false;
		}
		
		Solidocs::$registry->locale = $locale;
		$this->session->locale = $locale;
		
		if(isset($this->locales[$this->locale])){
			Solidocs::apply_config($this, $this->locales[$this->locale]);
		}
		
		date_default_timezone_set($this->timezone);
		
		if($this->autoload_strings AND $this->locale !== $this->default_locale){
			$this->load_strings(APP . '/I18n');
		}
	}
	
	/**
	 * Get locale
	 *
	 * @param string
	 * @return arry
	 */
	public function get_locale($locale){
		return $this->locales[$locale];
	}
	
	/**
	 * Get locales
	 *
	 * @return array
	 */
	public function get_locales(){
		return $this->accepted_locales;
	}
	
	/**
	 * Date
	 *
	 * @param integer
	 * @return string
	 */
	public function date($time){
		return date($this->date_format, $time);
	}
	
	/**
	 * Time
	 *
	 * @param integer
	 * @return string
	 */
	public function time($time){
		return date($this->time_format, $time);
	}
	
	/**
	 * Date time
	 *
	 * @param integer
	 * @return string
	 */
	public function date_time($time){
		return $this->date($time) . ' ' . $this->time($time);
	}
	
	/**
	 * Load strings
	 *
	 * @param string
	 * @param string	Optional.
	 */
	public function load_strings($file, $locale = null){
		if($locale == null){
			$locale = $this->locale;
		}
		
		$file .= '/' . $locale . '.txt';
		
		if(!file_exists($file)){
			throw new Exception('Could not load language file "' . $file . '"');
			return false;
		}
		
		$contents = file_get_contents($file);
		
		foreach(explode("\n", trim(file_get_contents($file))) as $line){
			if(!isset($line[0]) OR !isset($line[1])){
				throw new Exception('The language file "' . $file . '" is not correctly formated');
				return false;
			}
			
			$line = explode(' = ', $line);
			$this->strings[urlencode($line[0])] = $line[1];
		}
	}
	
	/**
	 * Translate
	 *
	 * @param string
	 * @param array		Optional.
	 * @return string
	 */
	public function translate($str, $args = array()){
		if(isset($this->strings[urlencode($str)])){
			$str = $this->strings[urlencode($str)];
		}
		
		array_unshift($args, $str);
		return call_user_func_array('sprintf', $args);
	}
	
	/**
	 * Conditional translate
	 *
	 * @param array
	 * @param mixed
	 * @param array		Optional.
	 * @return string
	 */
	public function cond_translate($strs, $cond, $args = array()){
		if(isset($strs[$cond])){
			$str = $strs[$cond];
		}
		elseif($cond == false AND isset($strs['false'])){
			$str = $strs['false'];
		}
		elseif($cond == true AND isset($strs['true'])){
			$str = $strs['true'];
		}
		elseif(isset($strs['fallback'])){
			$str = $strs['fallback'];
		}
		
		if(isset($str)){
			return $this->translate($str, $args);
		}
		
		return false;
	}
}