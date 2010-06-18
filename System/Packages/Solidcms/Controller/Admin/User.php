<?php
class Solidcms_Controller_Admin_User extends Solidocs_Controller_Action
{
	/**
	 * Index
	 */
	public function do_index(){
		$count = $this->db->select_from('user', 'COUNT(*)')->run()->one();		
		$pager = new Solidocs_Pager($count, 20);
		
		$users = $this->db->select_from('user')->limit($pager->limit, $pager->offset)->run()->arr();
		
		$this->load->view('Admin_Users', array(
			'users' => $users,
			'pager'	=> $pager
		));
	}
}