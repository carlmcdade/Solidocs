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
	 * Init
	 */
	public function init(){
		if(!is_array($this->accepted_locales)){
			$this->accepted_locales = explode(',', $this->accepted_locales);
		}
		
		if(isset($this->locales[$this->locale])){
			Solidocs::apply_config($this, $this->locales[$this->locale]);
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
}