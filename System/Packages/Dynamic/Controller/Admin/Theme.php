<?php
/**
 * Admin Theme Controller
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Admin
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class Dynamic_Controller_Admin_Theme extends Solidocs_Controller_Action
{
	/**
	 * Init
	 */
	public function init(){
		$this->load->library('File');
	}
	
	/**
	 * Index
	 */
	public function do_index(){
		$themes = array();
		
		foreach($this->file->dir(MEDIA . '/Theme') as $theme){
			if($this->config->file_exists(MEDIA . '/Theme/' . $theme . '/theme')){
				$theme_ini = $this->config->load_file(MEDIA . '/Theme/' . $theme . '/theme', true);
				
				$themes[$theme] = array(
					'name'			=> $theme_ini['name'],
					'description'	=> $theme_ini['description'],
					'version'		=> $theme_ini['version'],
					'num_regions'	=> count($theme_ini['regions'])
				);
			}
			else{
				$themes[$theme] = array(
					'name'			=> $theme,
					'description'	=> '',
					'version'		=> 'unknown',
					'num_regions'	=> 0
				);
			}
		}
		
		$this->load->view('Admin_Theme', array(
			'themes'	=> $themes
		));
	}
	
	/**
	 * Select
	 */
	public function do_select(){
		$this->load->model('Dynamic');
		
		$this->model->dynamic->set_config('Theme.theme', $this->input->uri_segment('id'));
		
		$this->output->add_flash_message('success', 'The theme has been set');
		
		$this->redirect('/admin/theme');
	}
}