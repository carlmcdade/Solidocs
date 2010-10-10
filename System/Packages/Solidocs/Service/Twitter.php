<?php
/**
 * Twitter Service
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php
 */
class Solidocs_Service_Twitter extends Solidocs_Base
{
	/**
	 * Get items
	 *
	 * @param string
	 * @param integer	Optional.
	 */
	public function get_items($username, $num_items = 10){
		// Check in cache
		if($this->cache->exists('twitter_' . $num_items . '_' . $username)){
			return $this->cache->get('twitter_' . $num_items . '_' . $username);
		}
		
		// Request URL
		$url = 'http://api.twitter.com/statuses/user_timeline.json?screen_name=' . $username;
		
		// Get tweets
		$json = json_decode(file_get_contents($url));
		
		// Request failed
		if($json == false){
			return array(
				(object) array(
					'title'	=> 'Twitter request failed',
					'link'	=> '',
					'time'	=> time()	
				)
			);
		}
		
		$items = array();
		
		// Loop feed and process item
		foreach($feed->items as $item){		
			$items[] = (object) array(
				'title'	=> $this->process_tweet($item->title),
				'link'	=> $item->link,
				'time'	=> $item->time
			);
		}
		
		// Store in cache
		$this->cache->store('twitter_' . $num_items . '_' . $username, $items, 60);
		
		// Return items
		return $items;
	}
	
	/**
	 * Process tweet
	 *
	 * Props to Allen Shaw & webmancers.com
	 *
	 * @param string
	 * @return string
	 */
	public function process_tweet($tweet){
		// Match protocol://address/path/file.extension?some=variable&another=asf%
		$tweet = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\">$1</a>", $tweet);
	
		// Match www.something.domain/path/file.extension?some=variable&another=asf%
    	$tweet = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\">$1</a>", $tweet);    

		// Match name@address
		$tweet = preg_replace("/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i","<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>", $tweet);
		
		/**
		 * Match #trendtopics
		 *
		 * @author Michael Voigt
		 */
		$tweet = preg_replace('/([\.|\,|\:|\�|\�|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/#search?q=$2\" class=\"twitter-link\">#$2</a>$3 ", $tweet);
		
		// Match mentioned Twitter users
		$tweet = preg_replace('/([\.|\,|\:|\�|\�|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\">@$2</a>$3 ", $tweet);
		
		// Return tweet
		return $tweet;
	}
}