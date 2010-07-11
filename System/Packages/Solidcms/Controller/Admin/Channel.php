<?php
class Solidcms_Controller_Admin_Channel extends Solidocs_Controller_Action
{
	/**
	 * Index
	 */
	public function do_index(){
		$channels = $this->db->select_from('channel')->run()->arr();
		
		foreach($channels as $i => $channel){
			$this->db->select_from('channel_item', 'COUNT(*)')->where(array(
				'channel' => $channel['channel']
			))->run();
			
			$channels[$i]['items'] = $this->db->one();
		}
		
		$this->load->view('Admin_Channels', array(
			'channels' => $channels
		));
	}
	
	/**
	 * Edit
	 */
	public function do_edit(){
		$data = $this->db->select_from('channel')->where(array(
			'channel' => $this->input->uri_segment('id')
		))->run()->fetch_assoc();
		
		$data['items'] = $this->db->select_from('channel_item')->where(array(
			'channel' => $data['channel']
		))->run()->arr();
		
		$this->load->view('Admin_Channel_Edit', $data);
	}
	
	/**
	 * Delete
	 */
	public function do_delete(){
	
	}
}