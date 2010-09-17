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
		
		// admin menu
		$this->db->insert_into('navigation', array(
			'navigation'	=> 'admin_menu',
			'name'			=> 'Admin Menu',
			'locale'		=> 'en_GB'
		))->run();
		
		// admin menu items
		$content_parent_id = $this->db->insert_into('navigation_item', array(
			'key'		=> 'admin_menu',
			'locale'	=> 'en_GB',
			'title'		=> 'Content',
			'url'		=> '/admin/content',
			'parent_id'	=> 0,
			'weight'	=> 1
		))->run()->insert_id();
		
		$navigation_parent_id = $this->db->insert_into('navigation_item', array(
			'key'		=> 'admin_menu',
			'locale'	=> 'en_GB',
			'title'		=> 'Navigation',
			'url'		=> '/admin/navigation',
			'parent_id'	=> 0,
			'weight'	=> 2
		))->run()->insert_id();
		
		$packages_parent_id = $this->db->insert_into('navigation_item', array(
			'key'		=> 'admin_menu',
			'locale'	=> 'en_GB',
			'title'		=> 'Packages',
			'url'		=> '/admin/packages',
			'parent_id'	=> 0,
			'weight'	=> 3
		))->run()->insert_id();
		
		$media_parent_id = $this->db->insert_into('navigation_item', array(
			'key'		=> 'admin_menu',
			'locale'	=> 'en_GB',
			'title'		=> 'Media',
			'url'		=> '/admin/media',
			'parent_id'	=> 0,
			'weight'	=> 4
		))->run()->insert_id();
		
		$theme_parent_id = $this->db->insert_into('navigation_item', array(
			'key'		=> 'admin_menu',
			'locale'	=> 'en_GB',
			'title'		=> 'Theme',
			'url'		=> '/admin/theme',
			'parent_id'	=> 0,
			'weight'	=> 5
		))->run()->insert_id();
		
		$users_parent_id = $this->db->insert_into('navigation_item', array(
			'key'		=> 'admin_menu',
			'locale'	=> 'en_GB',
			'title'		=> 'Users',
			'url'		=> '/admin/user',
			'parent_id'	=> 0,
			'weight'	=> 6
		))->run()->insert_id();
		
		$records = array(
			array(
				'key'		=> 'admin_menu',
				'locale'	=> 'en_GB',
				'title'		=> 'Dashboard',
				'url'		=> '/admin',
				'parent_id'	=> 0,
				'weight'	=> 0
			),
			array(
				'key'		=> 'admin_menu',
				'locale'	=> 'en_GB',
				'title'		=> 'Plugins',
				'url'		=> '/admin/plugins',
				'parent_id'	=> $packages_parent_id,
				'weight'	=> 0
			),
			array(
				'key'		=> 'admin_menu',
				'locale'	=> 'en_GB',
				'title'		=> 'Create',
				'url'		=> '/admin/content/create',
				'parent_id'	=> $content_parent_id,
				'weight'	=> 0
			),
			array(
				'key'		=> 'admin_menu',
				'locale'	=> 'en_GB',
				'title'		=> 'Types',
				'url'		=> '/admin/type',
				'parent_id'	=> $content_parent_id,
				'weight'	=> 1
			),
			array(
				'key'		=> 'admin_menu',
				'locale'	=> 'en_GB',
				'title'		=> 'Create type',
				'url'		=> '/admin/type/create',
				'parent_id'	=> $content_parent_id,
				'weight'	=> 2
			),
			array(
				'key'		=> 'admin_menu',
				'locale'	=> 'en_GB',
				'title'		=> 'Categories',
				'url'		=> '/admin/category',
				'parent_id'	=> $content_parent_id,
				'weight'	=> 3
			),
			array(
				'key'		=> 'admin_menu',
				'locale'	=> 'en_GB',
				'title'		=> 'Create category',
				'url'		=> '/admin/category/create',
				'parent_id'	=> $content_parent_id,
				'weight'	=> 4
			),
			array(
				'key'		=> 'admin_menu',
				'locale'	=> 'en_GB',
				'title'		=> 'Regions',
				'url'		=> '/admin/region',
				'parent_id'	=> $theme_parent_id,
				'weight'	=> 0
			),
			array(
				'key'		=> 'admin_menu',
				'locale'	=> 'en_GB',
				'title'		=> 'Settings',
				'url'		=> '/admin/theme/settings',
				'parent_id'	=> $theme_parent_id,
				'weight'	=> 1
			),
			array(
				'key'		=> 'admin_menu',
				'locale'	=> 'en_GB',
				'title'		=> 'Add user',
				'url'		=> '/admin/user/add',
				'parent_id'	=> $users_parent_id,
				'weight'	=> 0
			),
			array(
				'key'		=> 'admin_menu',
				'locale'	=> 'en_GB',
				'title'		=> 'Groups',
				'url'		=> '/admin/group',
				'parent_id'	=> $users_parent_id,
				'weight'	=> 1
			),
			array(
				'key'		=> 'admin_menu',
				'locale'	=> 'en_GB',
				'title'		=> 'Add group',
				'url'		=> '/admin/group/add',
				'parent_id'	=> $users_parent_id,
				'weight'	=> 2
			),
			array(
				'key'		=> 'admin_menu',
				'locale'	=> 'en_GB',
				'title'		=> 'Create',
				'url'		=> '/admin/navigation/create',
				'parent_id'	=> $navigation_parent_id,
				'weight'	=> 0
			),
			array(
				'key'		=> 'admin_menu',
				'locale'	=> 'en_GB',
				'title'		=> 'Add media',
				'url'		=> '/admin/media/add',
				'parent_id'	=> $media_parent_id,
				'weight'	=> 0
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
		$tables = $this->db->get_tables();
		
		$this->db->sql('DROP TABLE IF EXISTS `admin`')->run();
		
		if(in_array('navigation', $tables)){
			$this->db->delete_from('navigation')->where(array(
				'navigation' => 'admin_menu'
			))->run();
		}
		
		if(in_array('navigation_item', $tables)){
			$this->db->delete_from('navigation_item')->where(array(
				'key' => 'admin_menu'
			))->run();
		}
	}
}