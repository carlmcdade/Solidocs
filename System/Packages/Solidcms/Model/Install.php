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
		)
	);
}