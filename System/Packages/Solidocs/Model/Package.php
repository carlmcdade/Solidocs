<?php
/**
 * Solidocs Package Installer
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Dynamic
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Solidocs_Model_Package extends Solidocs_Base
{
	/**
	 * Install
	 */
	public function install(){
		// user table
		$this->db->sql('
		CREATE TABLE IF NOT EXISTS `user` (
		  `user_id` int(11) NOT NULL AUTO_INCREMENT,
		  `email` varchar(128) COLLATE utf8_bin NOT NULL,
		  `password` varchar(32) COLLATE utf8_bin NOT NULL,
		  `salt` varchar(32) COLLATE utf8_bin NOT NULL,
		  `group` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT \'user\',
		  PRIMARY KEY (`user_id`),
		  UNIQUE KEY `email` (`email`),
		  KEY `password` (`password`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;')->run();
		
		// group table
		$this->db->sql('
		CREATE TABLE IF NOT EXISTS `group` (
		  `group` varchar(32) COLLATE utf8_bin NOT NULL,
		  `name` varchar(32) COLLATE utf8_bin NOT NULL,
		  `description` varchar(256) COLLATE utf8_bin NOT NULL,
		  UNIQUE KEY `group` (`group`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;')->run();
		
		$this->db->insert_into('group', array(
			'group'			=> 'admin',
			'name'			=> 'Admin',
			'description'	=> 'The administrators group, this group can do everything.'
		))->run();
		
		$this->db->insert_into('group', array(
			'group'			=> 'user',
			'name'			=> 'User',
			'description'	=> 'Regular users on the site.'
		))->run();
		
		// insert default user
		$salt		= $this->user->generate_salt();
		$email		= 'admin@example.com';
		$password	= 'password';
		
		if($this->input->has_post('email')){
			$email = $this->input->post('email');
		}
		
		if($this->input->has_post('password')){
			$password = $this->input->post('password');
		}
		
		$this->db->insert_into('user', array(
			'email'		=> $email,
			'password'	=> $this->user->password(, $salt),
			'salt'		=> $salt,
			'group'		=> 'user,admin'
		))->run();
		
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
		  `parent_id` int(11) NOT NULL DEFAULT \'0\',
		  `weight` int(2) NOT NULL DEFAULT \'0\',
		  PRIMARY KEY (`navigation_item_id`),
		  KEY `key` (`key`),
		  KEY `order` (`weight`),
		  KEY `parent_id` (`parent_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;')->run();
		
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
				'url'		=> '/',
				'parent_id'	=> 0,
				'weight'	=> 0
			),
			array(
				'key'		=> 'main_menu',
				'locale'	=> 'en_GB',
				'title'		=> 'About',
				'url'		=> '/about',
				'parent_id'	=> 0,
				'weight'	=> 1
			)
		);
		
		foreach($records as $record){
			$this->db->insert_into('navigation_item', $record)->run();
		}
	}
	
	/**
	 * Uninstall
	 */
	public function uninstall(){
		$this->db->sql('DROP TABLE IF EXISTS `user`')->run();
		$this->db->sql('DROP TABLE IF EXISTS `group`')->run();
		$this->db->sql('DROP TABLE IF EXISTS `navigation`')->run();
		$this->db->sql('DROP TABLE IF EXISTS `navigation_item`')->run();
	}
}