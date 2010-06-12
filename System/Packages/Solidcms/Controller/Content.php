<?php
class Solidcms_Controller_Content extends Solidocs_Controller_Action
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
		$uri = '/' . trim($this->router->request_uri, '/') . '/';
		
		if($uri == '//'){
			$uri = '/';
		}
		
		$content = $this->model->cms->get_content(array(
			'uri' => $uri
		);
		
		if(count($content) == 0){
			$this->load->view('404');
		}
		else{
			$this->theme->title_parts[] = $content['title'];
			
			if(!empty($content['locale']) AND $content['locale'] !== $this->locale){
				$this->i18n->set_locale($content['locale']);
			}
						
			$this->load->view($content['view'], $content);
		}
	}
}