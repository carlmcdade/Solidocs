<?php
/**
 * CKEditor Package Installer
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Dynamic
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class CKEditor_Model_Package extends Solidocs_Base
{
	/**
	 * Install
	 */
	public function install(){
		$this->db->insert_into('content_type_helper', array(
			'helper' 	=> 'ckeditor',
			'name'		=> 'WYSIWYG (CKEditor)'
		))->run();
	}
	
	/**
	 * Uninstall
	 */
	public function uninstall(){
		$this->db->delete_from('content_type_helper')->where(array(
			'helper' => 'ckeditor'
		))->run();
	}
}