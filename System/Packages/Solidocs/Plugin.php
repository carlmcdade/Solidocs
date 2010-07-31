<?php
class Solidocs_Plugin extends Solidocs_Base
{
	/**
	 * Name
	 */
	public static $name = '';
	
	/**
	 * Description
	 */
	public static $description = '';
	
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