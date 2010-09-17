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
		// widget table
		$this->db->sql('
		CREATE TABLE IF NOT EXISTS `widget` (
		  `widget` varchar(64) COLLATE utf8_bin NOT NULL,
		  `name` varchar(64) COLLATE utf8_bin NOT NULL,
		  `default_config` text COLLATE utf8_bin NOT NULL,
		  UNIQUE KEY `widget` (`widget`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;')->run();
		
		$this->db->insert_into('widget', array(
			'widget' 			=> 'Solidocs_Widget_Text',
			'name'				=> 'Text Widget',
			'default_config'	=> 'a:2:{s:5:"title";s:5:"title";s:7:"content";s:7:"content";}'
		))->run();
		
		// region item table
		$this->db->sql('
		CREATE TABLE IF NOT EXISTS `region_item` (
		  `region_item_id` int(11) NOT NULL AUTO_INCREMENT,
		  `region` varchar(32) COLLATE utf8_bin NOT NULL,
		  `locale` char(5) COLLATE utf8_bin NOT NULL DEFAULT \'en_GB\',
		  `widget` varchar(128) COLLATE utf8_bin NOT NULL,
		  `config` text COLLATE utf8_bin NOT NULL,
		  `weight` int(2) NOT NULL,
		  PRIMARY KEY (`region_item_id`),
		  KEY `region` (`region`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;')->run();
		
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
		$this->db->sql('DROP TABLE IF EXISTS `widget`')->run();
		$this->db->sql('DROP TABLE IF EXISTS `region_item`')->run();
		$this->db->sql('DROP TABLE IF EXISTS `plugin`')->run();
		$this->db->sql('DROP TABLE IF EXISTS `config`')->run();
		$this->db->sql('DROP TABLE IF EXISTS `acl`')->run();
	}
}