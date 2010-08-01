<?php
class Solidadmin_Controller_Admin_Navigation extends Solidocs_Controller_Action
{
	/**
	 * Init
	 */
	public function init(){
		$this->theme->add_css(PACKAGE . '/Solidadmin/Media/navigation.css');
	}
	
	/**
	 * Index
	 */
	public function do_index(){
		$this->load->view('Admin_Navigation_List', array(
			'navigations' => $this->navigation->get_navigations()
		));
	}
	
	/**
	 * Create
	 */
	public function do_create(){
		if(count($this->i18n->locales) == 0){
			$locales[$this->i18n->default_locale] = $this->i18n->default_locale;
		}
		else{
			$locales = array();
			
			foreach($this->i18n->locales as $locale){
				$locales[$locale] = $locale;
			}
		}
		
		$form = new Solidocs_Form;
		$form->set_method('post');
		$form->set_action($this->router->uri);
		$form->add_element('navigation', array(
			'type' => 'text',
			'label' => 'Key (computer readable name)',
			'helper' => array('form_text')
		))->add_element('name', array(
			'type' => 'text',
			'label' => 'Name (human readable name',
			'helper' => array('form_text')
		))->add_element('locale', array(
			'type' => 'text',
			'label' => 'Locale',
			'helper' => array('form_select', $locales)
		))->add_element('Create', array(
			'label' => 'Save',
			'helper' => array('form_button')
		));
		
		if($form->is_posted()){
			if($form->is_valid()){
				$this->db->insert_into('navigation', $form->get_values())->run();
				
				$this->redirect('/admin/navigation/edit/' . $form->get_value('navigation'));
			}
		}
		
		$this->load->view('Admin_Navigation_Create', array(
			'form' => $form
		));
	}
	
	/**
	 * Edit
	 */
	public function do_edit(){
		if($this->input->has_post('item')){
			foreach($_POST['item'] as $id => $item){
				$this->db->update_set('navigation_item', $item)->where(array(
					'navigation_item_id' => $id
				))->run();
			}
		}
		
		if($this->input->has_post('new_item')){
			$item = $_POST['new_item'];
			$item['key'] = $this->input->uri_segment('id');
			
			$this->db->insert_into('navigation_item', $item)->run();
		}
		
		$parents = array(
			0 => 'none'
		);
		
		$this->db->select_from('navigation_item')->where(array(
			'key' => $this->input->uri_segment('id')
		))->run();
		
		while($item = $this->db->fetch_assoc()){
			$parents[$item['navigation_item_id']] = $item['title'] . ' (ID: ' . $item['navigation_item_id'] . ')';
		}
		
		$this->load->view('Admin_Navigation_Edit', array(
			'navigation' => $this->navigation->get_navigation($this->input->uri_segment('id')),
			'parents' => $parents
		));
	}
	
	/**
	 * Delete
	 */
	public function do_delete(){
		$this->db->delete_from('navigation_item')->where(array(
			'key' => $this->input->uri_segment('id')
		))->run();
		
		$this->db->delete_from('navigation')->where(array(
			'navigation' => $this->input->uri_segment('id')
		))->run();
		
		$this->redirect('/admin/navigation');
	}
	
	/**
	 * Delete item
	 */
	public function do_delete_item(){
		$this->db->delete_from('navigation_item')->where(array(
			'navigation_item_id' => $this->input->uri_segment('id')
		))->run();
		
		$this->redirect($this->input->get('redirect'));
	}
}