<?php
class Solidcms_Model_Install extends Solidocs_Install
{
	/**
	 * Tables
	 */
	public $tables = array(
		'acl' => array(
			'category' => array(
				'type' 		=> 'string',
				'length'	=> 64,
				'index'		=> true
			),
			'key' => array(
				'type'		=> 'string',
				'length'	=> 64,
				'index'		=> true
			),
			'action' => array(
				'type'		=> 'string',
				'length'	=> 64
			),
			'group' => array(
				'type'		=> 'string',
				'length'	=> 32
			)
		),
		
		'config' => array(
			'key' => array(
				'type' => 'string',
				'length' => 64,
				'index' => true
			),
			'value' => array(
				'type' => 'text'
			)
		),
		
		'plugin' => array(
			'class' => array(
				'type' => 'string',
				'length' => 128
			),
			'autoload' => array(
				'type' => 'bool',
				'default' => false,
				'index' => true
			)
		),
		
		'admin' => array(
			'item' => array(
				'type' => 'string',
				'length' => 64,
				'index' => true
			),
			'package' => array(
				'type' => 'string',
				'length' => 64
			),
			'controller' => array(
				'type' => 'string',
				'length' => 64
			)
		),
		
		'channel' => array(
			'channel' => array(
				'type' => 'string',
				'length' => 32
			),
			'name' => array(
				'type' => 'string',
				'length' => 32
			),
			'description' => array(
				'type' => 'string',
				'length' => 256
			)
		),
		
		'channel_item' => array(
			'channel_item_id' => array(
				'type' => 'integer',
				'length' => 11,
				'primary' => true,
				'auto_inc' => true
			),
			'channel' => array(
				'type' => 'string',
				'length' => 32,
				'index' => true
			),
			'url' => array(
				'type' => 'string',
				'length' => 256
			),
			'title' => array(
				'type' => 'string',
				'length' => 128
			),
			'parent_id' => array(
				'type' => 'integer',
				'length' => 3,
				'index' => true
			),
			'depth' => array(
				'type' => 'integer',
				'length' => 3,
				'index' => true
			),
			'weight' => array(
				'type' => 'integer',
				'length' => 3,
				'index' => true
			)
		),
		
		'content' => array(
			'content_id' => array(
				'type' => 'integer',
				'length' => 11,
				'primary' => true,
				'auto_inc' => true
			),
			'uri' => array(
				'type' => 'string',
				'length' => 128,
				'index' => true
			),
			'user_id' => array(
				'type' => 'integer',
				'length' => 11,
				'index' => true
			),
			'parent_id' => array(
				'type' => 'integer',
				'length' => 3,
				'index' => true
			),
			'depth' => array(
				'type' => 'integer',
				'length' => 3,
				'index' => true
			),
			'weight' => array(
				'type' => 'integer',
				'length' => 3,
				'index' => true
			),
			'content_type' => array(
				'type' => 'string',
				'length' => 32
			),
			'layout' => array(
				'type' => 'string',
				'length' => 32
			),
			'view' => array(
				'type' => 'string',
				'length' => 128
			),
			'tags' => array(
				'type' => 'string',
				'length' => 256
			),
			'description' => array(
				'type' => 'string',
				'length' => 256
			),
			'title' => array(
				'type' => 'string',
				'length' => 128
			),
			'content' => array(
				'type' => 'text'
			),
			'time' => array(
				'type' => 'integer',
				'length' => 10
			)
		),
		
		'content_type' => array(
			'content_type' => array(
				'type' => 'string',
				'length' => 32
			),
			'name' => array(
				'type' => 'string',
				'length' => 32
			),
			'description' => array(
				'type' => 'string',
				'length' => 32
			),
			'default_uri' => array(
				'type' => 'string',
				'length' => 128
			),
			'default_layout' => array(
				'type' => 'string',
				'length' => 128
			),
			'default_view' => array(
				'type' => 'string',
				'length' => 128
			)
		)
	);
	
	/**
	 * Data
	 */
	public $data = array(
		'plugin' => array(
			array(
				'class' => 'Solidocs_Plugin_Debug',
				'autoload' => true
			)
		),
		
		'admin' => array(
			array(
				'item' => 'dashboard',
				'package' => 'Solidcms',
				'controller' => 'Admin_Dashboard'
			),
			array(
				'item' => 'package',
				'package' => 'Solidcms',
				'controller' => 'Admin_Package'
			),
			array(
				'item' => 'user',
				'package' => 'Solidcms',
				'controller' => 'Admin_User'
			),
			array(
				'item' => 'content',
				'package' => 'Solidcms',
				'controller' => 'Admin_Content'
			)
		),
		
		'channel' => array(
			array(
				'channel' => 'admin_navigation',
				'name' => 'Admin Navigation',
				'description' => 'The navigation in the admin interface.'
			)
		),
		
		'channel_item' => array(
			array(
				'channel' => 'admin_navigation',
				'url' => '/admin',
				'title' => 'Dashboard'
			),
			array(
				'channel' => 'admin_navigation',
				'url' => '/admin/content',
				'title' => 'Content',
				'weight' => 1
			),
			array(
				'channel' => 'admin_navigation',
				'url' => '/admin/content/create',
				'title' => 'Create',
				'parent_id' => 2,
				'depth' => 1
			),
			array(
				'channel' => 'admin_navigation',
				'url' => '/admin/content/type',
				'title' => 'Types',
				'parent_id' => 2,
				'depth' => 1,
				'weight' => 1
			),
			array(
				'channel' => 'admin_navigation',
				'url' => '/admin/content/channel',
				'title' => 'Channels',
				'parent_id' => 2,
				'depth' => 1,
				'weight' => 2
			),
			array(
				'channel' => 'admin_navigation',
				'url' => '/admin/package',
				'title' => 'Packages',
				'weight' => 2
			),
			array(
				'channel' => 'admin_navigation',
				'url' => '/admin/package/plugin',
				'title' => 'Plugins',
				'parent_id' => 6,
				'depth' => 1
			),
			array(
				'channel' => 'admin_navigation',
				'url' => '/admin/user',
				'title' => 'Users',
				'weight' => 3
			),
			array(
				'channel' => 'admin_navigation',
				'url' => '/admin/user/acl',
				'title' => 'ACL',
				'parent_id' => 8,
				'depth' => 1
			)
		),
		
		'content' => array(
			array(
				'uri' => '/',
				'user_id' => 1,
				'content_type' => 'page',
				'view' => 'Solidcms_Page',
				'title' => 'Welcome',
				'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
				'time' => 1000000000
			)
		),
		
		'content_type' => array(
			array(
				'content_type' => 'page',
				'name' => 'Page',
				'description' => 'A regular page',
				'default_uri' => '/:page',
				'default_layout' => 'default',
				'default_view' => 'Solidcms_Page'
			)
		)
	);
}