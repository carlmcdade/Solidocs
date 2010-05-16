<?php
class Solidocs_I18n
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