<?php
/**
 * Media Package Installer
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Dynamic
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Media_Model_Package extends Solidocs_Base
{
	/**
	 * Install
	 */
	public function install(){
		// media table
		$this->db->sql('
		CREATE TABLE IF NOT EXISTS `media` (
		  `media_id` int(11) NOT NULL AUTO_INCREMENT,
		  `type` varchar(64) COLLATE utf8_bin NOT NULL,
		  `mime` varchar(64) COLLATE utf8_bin NOT NULL,
		  `height` int(5) NOT NULL,
		  `width` int(5) NOT NULL,
		  `length` int(5) NOT NULL,
		  `caption` varchar(256) COLLATE utf8_bin NOT NULL,
		  `path` varchar(256) COLLATE utf8_bin NOT NULL,
		  `time` int(10) NOT NULL,
		  PRIMARY KEY (`media_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;')->run();
	}
	
	/**
	 * Uninstall
	 */
	public function uninstall(){
		$this->db->sql('DROP TABLE IF EXISTS `media`')->run();
	}
}