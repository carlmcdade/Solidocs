<?php
/**
 * Node Package Installer
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Dynamic
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Node_Model_Package extends Solidocs_Base
{
	/**
	 * Install
	 */
	public function install(){
		// node table
		$this->db->sql('
		CREATE TABLE IF NOT EXISTS `node` (
		  `node_id` int(11) NOT NULL AUTO_INCREMENT,
		  `uri` varchar(128) COLLATE utf8_bin NOT NULL,
		  `locale` char(5) COLLATE utf8_bin NOT NULL DEFAULT \'en_GB\',
		  `title` varchar(128) COLLATE utf8_bin NOT NULL,
		  `tags` varchar(256) COLLATE utf8_bin NOT NULL,
		  `description` varchar(256) COLLATE utf8_bin NOT NULL,
		  `category` varchar(128) COLLATE utf8_bin NOT NULL,
		  `content` text COLLATE utf8_bin NOT NULL,
		  `media` text COLLATE utf8_bin NOT NULL,
		  `content_type` varchar(32) COLLATE utf8_bin NOT NULL,
		  `view` varchar(128) COLLATE utf8_bin NOT NULL,
		  `layout` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT \'default\',
		  `published` tinyint(1) NOT NULL DEFAULT \'1\',
		  PRIMARY KEY (`node_id`),
		  UNIQUE KEY `uri` (`uri`),
		  KEY `locale` (`locale`),
		  KEY `description` (`description`),
		  KEY `category` (`category`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;')->run();
		
		// default node
		$this->db->insert_into('node', array(
			'uri'			=> '/about',
			'locale'		=> 'en_GB',
			'title'			=> 'About',
			'content'		=> '<p>Welcome to Solidocs, this is a regular page loaded with Soldiocs\'s amazing Node package!</p>',
			'content_type'	=> 'page',
			'view'			=> 'Content_Page',
			'published'		=> 1
		))->run();
		
		// content_type table
		$this->db->sql('
		CREATE TABLE IF NOT EXISTS `content_type` (
		  `content_type` varchar(32) COLLATE utf8_bin NOT NULL,
		  `name` varchar(32) COLLATE utf8_bin NOT NULL,
		  `description` varchar(256) COLLATE utf8_bin NOT NULL,
		  UNIQUE KEY `content_type` (`content_type`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;')->run();
		
		$this->db->insert_into('content_type', array(
			'content_type'	=> 'page',
			'name'			=> 'Page',
			'description'	=> 'A regular page'
		))->run();
		
		// content_type_field table
		$this->db->sql('
		CREATE TABLE IF NOT EXISTS `content_type_field` (
		  `content_type` varchar(32) COLLATE utf8_bin NOT NULL,
		  `field` varchar(32) COLLATE utf8_bin NOT NULL,
		  `name` varchar(32) COLLATE utf8_bin NOT NULL,
		  `type` varchar(32) COLLATE utf8_bin NOT NULL,
		  `helper` varchar(64) COLLATE utf8_bin NOT NULL,
		  `filters` text COLLATE utf8_bin NOT NULL,
		  `validators` text COLLATE utf8_bin NOT NULL,
		  KEY `content_type` (`content_type`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;')->run();
		
		$this->db->insert_into('content_type_field', array(
			'content_type'	=> 'page',
			'field'			=> 'content',
			'name'			=> 'Body',
			'type'			=> 'text',
			'helper'		=> 'ckeditor'
		))->run();
		
		// content_type_helper table
		$this->db->sql('
		CREATE TABLE IF NOT EXISTS `content_type_helper` (
		  `helper` varchar(32) COLLATE utf8_bin NOT NULL,
		  `name` varchar(32) COLLATE utf8_bin NOT NULL,
		  KEY `helper` (`helper`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;')->run();
		
		$this->db->insert_into('content_type_helper', array(
			'helper'	=> 'form/text',
			'name'		=> 'Input Field'
		))->run();
		
		$this->db->insert_into('content_type_helper', array(
			'helper'	=> 'form/textarea',
			'name'		=> 'Textarea'
		))->run();
		
		$this->db->insert_into('content_type_helper', array(
			'helper'	=> 'form/file',
			'name'		=> 'File'
		))->run();
		
		$this->db->insert_into('content_type_helper', array(
			'helper'	=> 'xform/item_list',
			'name'		=> 'Item list'
		))->run();
		
		$this->db->insert_into('content_type_helper', array(
			'helper'	=> 'xform/select_bool',
			'name'		=> 'Select flag (boolean)'
		))->run();
	}

	/**
	 * Uninstall
	 */
	public function uninstall(){
		$this->db->sql('DROP TABLE IF EXISTS `node`')->run();
		$this->db->sql('DROP TABLE IF EXISTS `content_type`')->run();
		$this->db->sql('DROP TABLE IF EXISTS `content_type_field`')->run();
		$this->db->sql('DROP TABLE IF EXISTS `content_type_helper`')->run();
	}
}