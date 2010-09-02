<?php
/**
 * Node Controller
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Node
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Node_Controller_Node extends Solidocs_Controller_Action
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
		
		Solidocs::do_action('node_page', $node);
		
		$this->theme->set_layout($node->layout);
		$this->theme->add_title($node->title);
		$this->load->view($node->view, $node);
	}
	
	/**
	 * Category
	 */
	public function do_category(){
		$args = array(
			'category'	=> $this->input->uri_segment('category'),
			'locale'	=> $this->locale
		);
		
		if(!$this->user->in_group('admin')){
			$args['published'] = 1;
		}
		
		$nodes = $this->model->node->query_nodes($args);
		$category = $this->model->node->get_category($this->input->uri_segment('category'));
		
		$this->load->view('Content_Category', array(
			'nodes' => $nodes,
			'category' => $category['name']
		));
	}
}