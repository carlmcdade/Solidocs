<?php
/**
 * Feed
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php
 */
class Solidocs_Feed
{
	/**
	 * Get feed items
	 *
	 * @param string
	 */
	public function get_feed($url){
		$xml = simplexml_load_file($url);
		
		// RSS
		if(isset($xml->channel->item)){
			$rss = new Solidocs_Feed_Rss();
			
			$rss->set_xml($xml);
			
			return $rss;
		}
		// Atom
		elseif(isset($xml->entry)){
			/*$atom = new Solidocs_Feed_Atom();
			
			$atom->set_xml($xml);
			
			return $atom;*/
		}
	}
}