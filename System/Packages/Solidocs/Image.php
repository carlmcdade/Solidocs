<?php
/**
 * Image
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Solidocs_Image
{
	/**
	 * File
	 */
	public $file;
	
	/**
	 * File ext
	 */
	public $file_ext;
	
	/**
	 * Width
	 */
	public $width = 0;
	
	/**
	 * Height
	 */
	public $height = 0;
	
	/**
	 * Image canvas
	 */
	public $image_canvas;
	
	/**
	 * Destruct
	 */
	public function __destruct(){
		$this->clean();
	}
	
	/**
	 * Get width
	 *
	 * @return integer
	 */
	public function get_width(){
		return $this->width;
	}
	
	/**
	 * Get height
	 *
	 * @return integer
	 */
	public function get_height(){
		return $this->height;
	}
	
	/**
	 * Create file
	 *
	 * @param string
	 */
	public function create_file($file){
		$this->file = $file;
		
		$file = explode('.', $file);
		$this->file_ext = $file[count($file) - 1];
		
		list($this->width, $this->height) = getimagesize($this->file);
		
		switch($this->file_ext)
		{
			case 'jpg':
			case 'jpeg':
				$this->image_canvas	= imagecreatefromjpeg($this->file);
			break;
			
			case 'png':
				$this->image_canvas	= imagecreatefrompng($this->file);
			break;
			
			case 'gif':
				$this->image_canvas	= imagecreatefromgif($this->file);
			break;
		}
	}
	
	/**
	 * Clean
	 */
	public function clean(){
		if(is_resource($this->image_canvas)){
			imagedestroy($this->image_canvas);
		}
		
		$this->file		= '';
		$this->file_ext	= '';
		$this->width	= 0;
		$this->height	= 0;
	}
	
	/**
	 * Render file
	 */
	public function render_file($file = null){
		if(is_null($file)){
			$file = $this->file;
		}
		
		switch($this->file_ext)
		{
			case 'jpg':
			case 'jpeg':
				imagejpeg($this->image_canvas, $file);
			break;
			
			case 'png':
				imagepng($this->image_canvas, $file);
			break;
			
			case 'gif':
				imagegif($this->image_canvas, $file);
			break;
		}
		
		$this->clean();
	}
	
	/**
	 * Resize
	 *
	 * @param integer
	 * @param integer
	 */
	public function resize($width, $height){
		$this->crop(0, 0, $width, $height);
	}
	
	/**
	 * Crop
	 *
	 * @param integer
	 * @param integer
	 * @param integer
	 * @param integer
	 */
	public function crop($x, $y, $width, $height){
		$tmp_canvas = imagecreatetruecolor($width, $height);
		
		imagecopyresampled($tmp_canvas, $this->image_canvas, 0, 0, $x, $y, $width, $height, $this->width, $this->height);
		
		$this->image_canvas	= $tmp_canvas;
		$this->width		= $width;
		$this->height		= $height;
	}
}