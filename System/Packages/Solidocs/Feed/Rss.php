<?php
/**
 * RSS Feed Class
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php
 */
class Solidocs_Feed_Rss extends Solidocs_Feed_Feed
{
	/**
	 * Set xml
	 *
	 * @param object
	 */
	public function set_xml($xml){
		// Set title, link and description
		$this->set_title(		(string) $xml->channel->title);
		$this->set_link(		(string) $xml->channel->link);
		$this->set_description(	(string) $xml->channel->description);
		
		// Parse items
		foreach($xml->channel->item as $item){
			$this->add_item(array(
				'title'			=> (string) $item->title,
				'description'	=> (string) $item->description,
				'link'			=> (string) $item->link,
				'guid'			=> (string) $item->guid,
				'time'			=> strtotime($item->pubDate),
				'pubDate'		=> (string) $item->pubDate
			));
		}
	}
}