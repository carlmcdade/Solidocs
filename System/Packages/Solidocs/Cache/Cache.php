<?php
/**
 * Cache Adapter Base
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Solidocs_Cache_Cache extends Solidocs_Base
{
	/**
	 * Init
	 */
	public function init(){
		$this->connect();
	}
}