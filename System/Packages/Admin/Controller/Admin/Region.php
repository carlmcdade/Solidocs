<?php
/**
 * Admin Regions Controller
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Admin
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class Admin_Controller_Admin_Region extends Solidocs_Controller_Action
{
	/**
	 * Init
	 */
	public function init(){
		$this->load->model('Theme');
	}
	
	/**
	 * Index
	 */
	public function do_index(){
		$this->load->view('Admin_Region_List', array(
			'regions' => $this->model->theme->get_regions()
		));
	}
	
	/**
	 * Edit
	 */
	public function do_edit(){
		$locale = $this->input->get('locale', 'en_GB');
		
		$widgets = array();
		
		foreach($this->model->theme->get_widgets() as $widget){
			$widgets[$widget['widget']] = $widget['name'];
		}
		
		if($this->input->has_post('new')){
			$this->model->theme->add_widget($this->input->uri_segment('id'), $locale, $this->input->post('new'));
			
			$this->output->add_flash_message('success', 'Added the widget to the region');
			
			$this->redirect('/admin/region/edit/' . $this->input->uri_segment('id') . '?locale=' . $locale);
		}
		
		if($this->input->has_post('item')){
			foreach($this->input->post('item') as $region_item_id => $item){
				$this->model->theme->update_widget($region_item_id, $item);
			}
			
			$this->output->add_flash_message('success', 'The widgets has been successfully updated');
			
			$this->redirect('/admin/region/edit/' . $this->input->uri_segment('id') . '?locale=' . $locale);
		}
		
		$this->load->view('Admin_Region_Edit', array(
			'items' 	=> $this->model->theme->get_region_items($this->input->uri_segment('id'), $locale),
			'widgets'	=> $widgets
		));
	}
	
	/**
	 * Delete item
	 */
	public function do_delete_item(){
		$region_item = $this->model->theme->get_region_item($this->input->uri_segment('id'));
		
		$this->model->theme->delete_region_item($this->input->uri_segment('id'));
		
		$this->output->add_flash_message('success', 'Removed the widget from the region');
		
		$this->redirect('/admin/region/edit/' . $region_item['region'] . '?locale=' . $region_item['locale']);
	}
}