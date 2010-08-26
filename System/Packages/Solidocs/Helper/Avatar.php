<?php
/**
 * Avatar Helper
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Solidocs_Helper_Avatar extends Solidocs_Helper
{
	/**
	 * Gravatar
	 *
	 * @param string
	 * @param integer	Optional. [ 1 - 512 ]
	 * @param string	Optional. [ 404 | mm | identicon | monsterid | wavatar ]
	 * @param string	Optional. [ g | pg | r | x ]
	 * @return string	Optional.
	 */
	public function gravatar($email, $size = 80, $default = 'mm', $rating = 'g'){
		$this->load->library('Service_Gravatar');
		
		return $this->service_gravatar->get_gravatar($email, $size, $default, $rating);
	}
	
	/**
	 * Gravatar img
	 *
	 * @param string
	 * @param integer	Optional. [ 1 - 512 ]
	 * @param string	Optional. [ 404 | mm | identicon | monsterid | wavatar ]
	 * @param string	Optional. [ g | pg | r | x ]
	 * @return string	Optional.
	 */
	public function gravatar_img($email, $size = 80, $default = 'mm', $rating = 'g'){
		return '<img src="' . $this->gravatar($email, $size, $default, $rating) . '" />';
	}
}