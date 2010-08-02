<?php
class Solidnode_Controller_Admin_Content extends Solidocs_Controller_Action
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
		$this->load->view('Admin_Content_List', array(
			'nodes' => $this->model->node->get_nodes()
		));
	}
	
	/**
	 * Edit
	 */
	public function do_edit(){
		$node_id = $this->input->uri_segment('id', 0);
		
		if($node_id == 0){
			$content_type = $this->model->node->get_type_fields($this->input->get('content_type', 'page'));
			$node = array(
				'node_id' => 0
			);
			
			foreach($content_type as $field => $properties){
				$node[$field] = '';
			}
		}
		else{
			$node = $this->model->node->get_node(array(
				'node_id' => $node_id
			));
			$content_type = $this->model->node->get_type_fields($node->content_type);
		}
		
		if(!is_array($node->content)){
			$node->content = array('content' => $node->content);
		}
		
		$form = new Solidnode_Form_Edit(false);
		$form->init($content_type);
		
		if($form->is_posted() AND $this->input->has_post()){
			$form->set_values($_POST);
			
			if($form->is_valid()){
				$form->process_values();
				
				$values = $form->get_values();
				
				if($values['node_id'] == 0 OR empty($values['node_id'])){
					unset($values['node_id']);
					
					if(isset($_GET['content_type'])){
						$values['content_type'] = $this->input->get('content_type');
					}
					
					$this->model->node->create($values);
				}
				else{
					$this->model->node->update($values['node_id'], $values);
				}
			}
		}
		else{
			$form->set_values($node);
		}
		
		$this->load->view('Admin_Content_Edit', array(
			'form' => $form
		));
	}
	
	/**
	 * Create
	 */
	public function do_create(){
		$this->load->view('Admin_Content_Create', array(
			'content_types' => $this->model->node->get_types()
		));
	}
}