<?php
/**
 * Admin Package Installer
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Dynamic
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Admin_Model_Package extends Solidocs_Base
{
	/**
	 * Install
	 */
	public function install(){
		$this->db->sql(
		'CREATE TABLE IF NOT EXISTS `admin` (
			`item` varchar(64) COLLATE utf8_bin NOT NULL,
			`controller` varchar(64) COLLATE utf8_bin NOT NULL,
			KEY `item` (`item`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;')->run();
		
		$records = array(
			array(
				'item' => 'dashboard',
				'controller' => 'Admin_Dashboard'
			),
			array(
				'item' => 'admin',
				'controller' => 'Admin_Admin'
			),
			array(
				'item' => 'content',
				'controller' => 'Admin_Content'
			),
			array(
				'item' => 'packages',
				'controller' => 'Admin_Packages'
			),
			array(
				'item' => 'plugins',
				'controller' => 'Admin_Plugins'
			),
			array(
				'item' => 'navigation',
				'controller' => 'Admin_Navigation'
			),
			array(
				'item' => 'type',
				'controller' => 'Admin_Type'
			),
			array(
				'item' => 'category',
				'controller' => 'Admin_Category'
			),
			array(
				'item' => 'media',
				'controller' => 'Admin_Media'
			),
			array(
				'item' => 'user',
				'controller' => 'Admin_User'
			),
			array(
				'item' => 'theme',
				'controller' => 'Admin_Theme'
			),
			array(
				'item' => 'group',
				'controller' => 'Admin_Group'
			),
			array(
				'item' => 'region',
				'controller' => 'Admin_Region'
			)
		);
		
		foreach($records as $record){
			$this->db->insert_into('admin', $record)->run();
		}
	}
	
	/**
	 * Uninstall
	 */
	public function uninstall(){
		$this->db->sql('DROP TABLE IF EXISTS `admin`')->run();
	}
}