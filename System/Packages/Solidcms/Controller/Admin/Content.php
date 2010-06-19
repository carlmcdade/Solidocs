<?php
class Solidcms_Controller_Admin_Content extends Solidocs_Controller_Action
{
	/**
	 * Index
	 */
	public function do_index(){
		$content = $this->db->select_from('content')->order('content_id', 'ASC')->run()->arr();
		
		$this->load->view('Admin_Content', array(
			'content' => $content
		));
	}
	
	/**
	 * Types
	 */
	public function do_type(){
		$content_types = $this->db->select_from('content_type')->run()->arr();
		
		$this->load->view('Admin_Types', array(
			'content_types' => $content_types
		));
	}
	
	/**
	 * Channel
	 */
	public function do_channel(){
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
}