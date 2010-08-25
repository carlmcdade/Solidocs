<?php
/**
 * Media Admin Controller
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Media_Controller_Admin_Media extends Solidocs_Controller_Action
{
	/**
	 * Init
	 */
	public function init(){
		$this->load->model('Media');
		
		$this->theme->add_title('Media');
	}
	
	/**
	 * Index
	 */
	public function do_index(){
		$this->load->view('Admin_Media_List', array(
			'media_items' => $this->model->media->get_all()
		));
	}
	
	/**
	 * Add
	 */
	public function do_add(){
		if($this->input->has_file('file')){
			$this->load->library('File');
			
			$file = $this->input->file('file');
			
			$destination = UPLOAD . '/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
			
			if(!file_exists($destination)){
			    $this->file->mkdir($destination);
			}
			
			$destination	.= $file['name'];
			$type			= explode('/', $file['type']);
			$type			= $type[0];
			$width			= $this->input->post('width');
			$height			= $this->input->post('height');
			
			$this->file->upload_file($file['tmp_name'], $destination);
			
			
			if($type == 'image'){
				$this->load->library('Image');
				
				$this->image->create_file($destination);
				
				$width	= $this->image->get_width();
				$height = $this->image->get_height();
				
				$this->image->clean();
			}
			
			$this->model->media->add_media(array(
				'path' 		=> str_replace(ROOT, '', $destination),
				'type'		=> $type,
				'mime'		=> $file['type'],
				'height'	=> $height,
				'width'		=> $width,
				'length'	=> $this->input->post('length'),
				'time'		=> time()
			));
			
			$this->output->add_message('The item was created');
		}
		
		$this->load->view('Admin_Media_Add');
	}
	
	/**
	 * Delete
	 */
	public function do_delete(){
		$this->model->media->delete($this->input->uri_segment('id'));
		
		$this->output->add_flash_message('success', 'Successfully deleted the item.');
		
		$this->redirect('/admin/media');
	}
}