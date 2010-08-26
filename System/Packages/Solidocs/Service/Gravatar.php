<?php
/**
 * Gravatar Service
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Solidocs_Service_Gravatar extends Solidocs_Base
{
	/**
	 * Get gravatar
	 *
	 * @param string
	 * @param integer	Optional. [ 1 - 512 ]
	 * @param string	Optional. [ 404 | mm | identicon | monsterid | wavatar ]
	 * @param string	Optional. [ g | pg | r | x ]
	 * @return string	Optional.
	 */
	public function get_gravatar($email, $size = 80, $default = 'mm', $rating = 'g'){
		$url = 'http://www.gravatar.com/avatar/';
		$url .= md5(strtolower(trim($email)));
		$url .= '?s=' . $size . '&d= ' . $default . '&r=' . $rating;
		
		return $url;
	}
}