<?php
/**
 * Helper
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Solidocs_Helper extends Solidocs_Base
{
	/**
	 * Call
	 *
	 * @param string
	 * @param array
	 */
	public function __call($method, $params){
		return $this->output->helper($method, $params);
	}
}