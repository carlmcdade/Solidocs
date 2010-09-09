<?php
class Solidocs_Model_Package extends Solidocs_Base
{
	public function install(){
		// navigation table
		$this->db->sql('
		CREATE TABLE IF NOT EXISTS `navigation` (
		  `navigation` varchar(32) COLLATE utf8_bin NOT NULL,
		  `name` varchar(32) COLLATE utf8_bin NOT NULL,
		  `locale` char(5) COLLATE utf8_bin NOT NULL DEFAULT "en_GB",
		  KEY `navigation` (`navigation`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;')->run();
		
		// navigation_item table
		$this->db->sql('
		CREATE TABLE IF NOT EXISTS `navigation_item` (
		  `navigation_item_id` int(11) NOT NULL AUTO_INCREMENT,
		  `key` varchar(32) COLLATE utf8_bin NOT NULL,
		  `locale` char(5) COLLATE utf8_bin NOT NULL DEFAULT "en_GB",
		  `title` varchar(128) COLLATE utf8_bin NOT NULL,
		  `url` varchar(128) COLLATE utf8_bin NOT NULL,
		  `parent_id` int(11) NOT NULL DEFAULT '0',
		  `weight` int(2) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`navigation_item_id`),
		  KEY `key` (`key`),
		  KEY `order` (`weight`),
		  KEY `parent_id` (`parent_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin')->run();
		
		// main menu
		$this->db->insert_into('navigation', array(
			'navigation'	=> 'main_menu',
			'name'			=> 'Main Menu',
			'locale'		=> 'en_GB'
		))->run();
		
		// main menu items
		$records = array(
			array(
				'key'		=> 'main_menu',
				'locale'	=> 'en_GB',
				'title'		=> 'Home',
				'uri'		=> '/',
				'parent_id'	=> 0,
				'weight'	=> 0
			),
			array(
				'key'		=> 'main_menu',
				'locale'	=> 'en_GB',
				'title'		=> 'About',
				'uri'		=> '/about',
				'parent_id'	=> 0,
				'weight'	=> 0
			)
		);
		
		foreach($records as $record){
			$this->db->insert_into('navigation_item', $record)->run();
		}
	}
	
	public function uninstall(){
		$this->db->sql('DROP TABLE IF EXISTS `navigation`')->run();
		$this->db->sql('DROP TABLE IF EXISTS `navigation_item`')->run();
	}
}