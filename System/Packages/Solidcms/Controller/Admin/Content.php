<?php
class Solidcms_Controller_Admin_Content extends Solidocs_Controller_Action
{
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