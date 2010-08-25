<?php
/**
 * Dynamic Package Installer
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Dynamic
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Dynamic_Model_Package extends Solidocs_Base
{
	/**
	 * Install
	 */
	public function install(){
		// plugin.table
		$this->db->sql(
		'CREATE TABLE IF NOT EXISTS `plugin` (
			`class` varchar(128) COLLATE utf8_bin NOT NULL,
			`autoload` tinyint(1) NOT NULL DEFAULT \'0\',
			KEY `autoload` (`autoload`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		')->run();
		
		// config.table
		$this->db->sql(
		'CREATE TABLE IF NOT EXISTS `config` (
			`key` varchar(64) COLLATE utf8_bin NOT NULL,
			`value` text COLLATE utf8_bin NOT NULL,
			KEY `key` (`key`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		')->run();
		
		// acl.table
		$this->db->sql(
		'CREATE TABLE IF NOT EXISTS `acl` (
			`category` varchar(64) COLLATE utf8_bin NOT NULL,
			`key` varchar(64) COLLATE utf8_bin NOT NULL,
			`action` varchar(64) COLLATE utf8_bin NOT NULL,
			`group` varchar(32) COLLATE utf8_bin NOT NULL,
			KEY `category` (`category`),
			KEY `key` (`key`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		')->run();
		
		// Default plugin
		$this->db->insert_into('plugin', array(
			'class' => 'Solidocs_Plugin_Debug',
			'autoload' => false
		))->run();
	}
	
	/**
	 * Uninstall
	 */
	public function uninstall(){
		$this->db->sql('DROP TABLE IF EXISTS `plugin`')->run();
		$this->db->sql('DROP TABLE IF EXISTS `config`')->run();
		$this->db->sql('DROP TABLE IF EXISTS `acl`')->run();
	}
}