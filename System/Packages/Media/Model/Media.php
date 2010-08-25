<?php
/**
 * Media Model
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Media_Model_Media extends Solidocs_Base
{
	/**
	 * Get all
	 */
	public function get_all(){
		$this->db->select_from('media')->run();
		
		return $this->db->arr();
	}
	
	/**
	 * Get
	 *
	 * @param integer
	 */
	public function get($media_id){
		$this->db->select_from('media')->where(array(
			'media_id' => $media_id
		))->run();
		
		return $this->db->fetch_assoc();
	}
	
	/**
	 * Add
	 *
	 * @param array
	 */
	public function add_media($media){
		$this->db->insert_into('media', $media)->run();
	}
	
	/**
	 * Delete
	 *
	 * @param integer
	 */
	public function delete($media_id){
		$this->db->delete_from('media')->where(array(
			'media_id' => $media_id
		))->run();
	}
}