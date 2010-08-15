<?php
/**
 * Solidocs Install
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
$config = array(
	'tables' => array(
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
	),

	'data' => array(
		'user'	=> array(
			array(
				'email'		=> 'admin@example.com',
				'username'	=> 'admin',
				'password'	=> 'password',
				'group'		=> 'user,admin'
			)
		)
	)
);