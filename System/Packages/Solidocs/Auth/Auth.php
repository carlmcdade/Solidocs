<?php
/**
 * Abstract Authentication Base
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
abstract class Solidocs_Auth_Auth extends Solidocs_Base
{
	/**
	 * Identity
	 */
	public $identity;
	
	/**
	 * Set identity
	 *
	 * @param array
	 */
	public function set_identity($identity){
		$this->identity = $identity;
	}
	
	/**
	 * Get identity
	 *
	 * @return array
	 */
	public function get_identity(){
		return $this->identity;
	}
}