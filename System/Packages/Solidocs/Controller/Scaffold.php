<?php
class Solidocs_Controller_Scaffold extends Solidocs_Controller_Action
{
	/**
	 * Table
	 */
	public $table;
	
	/**
	 * List
	 */
	public $list;
	
	/**
	 * Fields
	 */
	public $fields;
	
	/**
	 * Id
	 */
	public $id;
	
	/**
	 * Init
	 */
	public function init(){
		$this->db->select_from($this->table)->limit(1)->run();
		$this->fields = array_keys($this->db->fetch_assoc());
	}
	
	/**
	 * Index
	 */
	public function do_index(){
		$action = 'list';
		
		if($this->input->has_uri_segment('action') AND in_array($this->input->uri_segment('action'), array('list', 'edit', 'add', 'delete'))){
			$action = $this->input->uri_segment('action');
		}
		
		$this->forward($action);
	}
	
	/**
	 * List
	 */
	public function do_list(){
		$records = $this->db->select_from($this->table)->run()->arr();
		
		if(is_array($this->list)){
			foreach($this->fields as $key => $field){
				if(!in_array($field, $this->list)){
					unset($this->fields[$key]);
				}
			}
			
			foreach($records as $i => $record){
				foreach($record as $key => $val){
					if(!in_array($key, $this->list)){
						unset($records[$i][$key]);
					}
				}
			}
		}
		
		$this->load->view('Scaffold_List', array(
			'records' => $records,
			'fields' => $this->fields,
			'table' => $this->table
		));
	}
	
	/**
	 * Edit
	 */
	public function do_edit(){
		$this->db->select_from($this->table)->where(array(
			$this->id => $this->input->uri_segment('id')
		))->run();
		
		$this->load->view('Scaffold_Edit', array(
			'record' => $this->db->fetch_assoc(),
			'table' => $this->table
		));
	}
	
	/**
	 * Add
	 */
	public function do_add(){
	
	}
	
	/**
	 * Delete
	 */
	public function do_delete(){
	
	}
}