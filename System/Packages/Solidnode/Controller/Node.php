<?php
class Solidnode_Controller_Node extends Solidocs_Controller_Action
{
	/**
	 * Init
	 */
	public function init(){
		$this->load->model('Node');
	}
	
	/**
	 * Index
	 */
	public function do_index(){
		$node = $this->model->node->get(array(
			'uri' => $this->router->request_uri
		));
		
		if($node == false){
			throw new Exception('No node could be found', 404);
		}
		
		if($node->locale !== $this->locale){
			$this->i18n->set_locale($node->locale);
		}
		
		$this->theme->add_title($node->title);
		$this->load->view($node->view, $node);
	}
}