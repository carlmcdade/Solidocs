<?php
class Solidocs_Model_Install extends Solidocs_Install
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
		
		'user' => array(
			'user_id' => array(
				'type'		=> 'integer',
				'length'	=> 11,
				'auto_inc'	=> true,
				'primary'	=> true
			),
			'email' => array(
				'type'		=> 'string',
				'length'	=> 128,
				'unique'	=> true
			),
			'username' => array(
				'type'		=> 'string',
				'length'	=> 32,
				'unique'	=> true
			),
			'password' => array(
				'type'		=> 'string',
				'length'	=> 32,
				'index'		=> true
			),
			'group' => array(
				'type'		=> 'string',
				'length'	=> 256,
				'default'	=> 'user'
			)
		)
	);
}