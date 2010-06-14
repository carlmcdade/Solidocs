<?php
class Solidocs_Plugin extends Solidocs_Base
{
	/**
	 * Name
	 */
	public $name = '';
	
	/**
	 * Description
	 */
	public $description = '';
	
	/**
	 * Version
	 */
	public $version = 'unkown';
	
	/**
	 * Url
	 */
	public $url;
	
	/**
	 * Install
	 */
	public function install(){
		return true;
	}
	
	/**
	 * Uninstall
	 */
	public function uninstall(){
		return true;
	}
}