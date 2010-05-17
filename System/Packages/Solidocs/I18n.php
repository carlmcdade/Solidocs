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
	 * Init
	 */
	public function init(){
		if(!is_array($this->accepted_locales)){
			$this->accepted_locales = explode(',', $this->accepted_locales);
		}
		
		if($this->auto_localize){
			if(isset($_SESSION['locale'])){
				$locale = $_SESSION['locale'];
			}
			elseif(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
				$lang = explode('-',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
				$locale = $lang[0].'_'.strtoupper($lang[1]);
			}
			else{
				$locale = $this->default_locale;
			}
			
			if(in_array($locale,$this->accepted_locales)){
				Solidocs::$registry->locale = $locale;
				$_SESSION['locale'] = $locale;
			}
		}
		
		if(isset($this->locales[$this->locale])){
			Solidocs::apply_config($this, $this->locales[$this->locale]);
		}
		
		setlocale(LC_MESSAGES , $this->locale);
		
		putenv('LANG=' . $this->locale . '.utf8');
		putenv('LANGUAGE=' . $this->locale . '.utf8');
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
}