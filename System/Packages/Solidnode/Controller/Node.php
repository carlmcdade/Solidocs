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
		$args = array(
			'uri' => $this->router->request_uri
		);
		
		if(!$this->user->in_group('admin')){
			$args['published'] = 1;
		}
		
		$node = $this->model->node->get_node($args);
		
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