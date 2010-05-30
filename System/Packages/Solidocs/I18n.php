<?php
class Solidocs_I18n extends Solidocs_Base
{
	/**
	 * Date format
	 */
	public $date_format = 'Y-m-d';
	
	/**
	 * Time format
	 */
	public $time_format = 'H:i:is';
	
	/**
	 * Accepted locales
	 */
	public $accepted_locales = array('en_GB');
	
	/**
	 * Locales
	 */
	public $locales;
	
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
			if(isset($this->session->locale)){
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
		Solidocs::$registry->locale = $locale;
		$this->session->locale = $locale;
		
		if(isset($this->locales[$this->locale])){
			Solidocs::apply_config($this, $this->locales[$this->locale]);
		}
		
		setlocale(LC_MESSAGES , $this->locale);
		
		putenv('LANG=' . $this->locale . '.utf8');
		putenv('LANGUAGE=' . $this->locale . '.utf8');
		
		if($this->autoload_strings AND $this->locale !== $this->default_locale){
			$this->load_strings(APP . '/I18n');
		}
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
	 * @param string	$file
	 * @param string	$locale	Optional.
	 */
	public function load_strings($file, $locale = null){
		if($locale == null){
			$locale = $this->locale;
		}
		
		$file .= '/' . $locale . '.txt';
		
		if(!file_exists($file)){
			trigger_error('Could not load language file "' . $file . '"');
			return false;
		}
		
		$contents = file_get_contents($file);
		
		foreach(explode("\n", trim(file_get_contents($file))) as $line){
			if(!isset($line[0]) OR !isset($line[1])){
				trigger_error('The language file "' . $file . '" is not correctly formated');
				return false;
			}
			
			$line = explode(' = ', $line);
			$this->strings[urlencode($line[0])] = $line[1];
		}
	}
	
	/**
	 * Translate
	 *
	 * @param string	$str
	 * @param array		$args	Optional.
	 */
	public function translate($str, $args = array()){
		if(isset($this->strings[urlencode($str)])){
			$str = $this->strings[urlencode($str)];
		}
		
		array_unshift($args, $str);
		return call_user_func_array('sprintf', $args);
	}
}