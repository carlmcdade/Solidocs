<?php
/**
 * User Group Administration Controller
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Admin
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Admin_Controller_Admin_Group extends Solidocs_Controller_Action
{
	/**
	 * Index
	 */
	public function do_index(){
		$this->db->select_from('group')->run();
		
		$this->load->view('Admin_Group_List', array(
			'groups' => $this->db->arr()
		));
	}
}