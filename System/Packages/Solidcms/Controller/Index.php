<?php
class Solidcms_Controller_Index extends Solidocs_Controller_Action
{
	/**
	 * Init
	 */
	public function init(){
		$this->load->model('cms', 'Solidcms');
	}
	
	/**
	 * Reciever
	 */
	public function do_index(){
		$content = $this->model->cms->get_content(array(
			'uri'		=> trim($this->router->request_uri, '/'),
			'locale'	=> $this->locale
		));
		
		if(count($content) == 0){
			$this->load->view('404');
		}
		else{
			$this->theme->title_parts[] = $content['title'];
						
			$this->load->view($content['view'], $content);
		}
	}
}