<?php
/**
 * Node Content Admin Controller
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Node
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Node_Controller_Admin_Content extends Solidocs_Controller_Action
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
		
		$form = new Node_Form_Edit(false);
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
					$this->output->add_message('success', 'The node was successfully created.');
				}
				else{
					foreach($form->elements as $element_key => $element){
						if($element['type'] == 'array'){
							$element_key = trim(str_replace('content[', '', $element_key), ']');
							
							foreach($values['content'][$element_key] as $key => $val){
								if(empty($val)){
									unset($values['content'][$element_key][$key]);
								}
							}
						}
						elseif($element['type'] == 'file'){
							if($this->input->has_file($element_key)){
								$file = $this->input->file($element_key);
								$destination = UPLOAD . '/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
								
								$this->load->library('File');
								
								if(!file_exists($destination)){
									$this->file->mkdir($destination);
								}
								
								$destination .= $file['name'];
								
								if($this->file->upload_file($file['tmp_name'], $destination)){
									$values['content'][trim(str_replace('content[', '', $element_key), ']')] = str_replace(ROOT, '', $destination);
								}
								else{
									$this->output->add_message('There was a problem uploading the file.');
								}
							}
						}
					}
					
					$form->set_values($values);
					$this->model->node->update($values['node_id'], $values);
					$this->output->add_message('success', 'The node was successfully updated.');
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
	
	/**
	 * Delete
	 */
	public function do_delete(){
		$this->model->node->delete($this->input->uri_segment('id'));
		
		$this->output->add_flash_message('success', 'The node was successfully deleted');
		
		$this->redirect('/admin/content');
	}
	
	/**
	 * Unpublish
	 */
	public function do_unpublish(){
		$this->model->node->update($this->input->uri_segment('id'), array(
			'published' => 0
		));
		
		$this->output->add_flash_message('The node is not published anymore');
		
		$this->redirect('/admin/content');
	}
	
	/**
	 * Publish
	 */
	public function do_publish(){
		$this->model->node->update($this->input->uri_segment('id'), array(
			'published' => 1
		));
		
		$this->output->add_flash_message('success', 'The node is now published');
		
		$this->redirect('/admin/content');
	}
}