<?php
class Solidcms_Helper_List extends Solidocs_Helper
{
	/**
	 * Feed
	 *
	 * @param string
	 * @param array		Optional.
	 */
	public function feed($feed, $args = array()){
		$defaults = array(
			'locale'		=> $this->locale,
			'limit'			=> 20,
			'link'			=> true,
			'before_item'	=> '<li>',
			'after_item'	=> '</li>'
		);
		
		$args = array_merge($defaults, $args);
		
		$this->db
			->select('solidcms_content.uri,solidcms_content.title,solidcms_content.feed_title')
			->from('solidcms_feed_item')
			->join('solidcms_content','solidcms_feed_item.content_id','solidcms_content.content_id')
			->where(array(
				'solidcms_feed_item.feed' => $feed
			))
			->order('weight', 'DESC')
			->limit($args['limit'])
			->run();
		
		foreach($this->db->arr() as $item){
			if(!empty($item['feed_title'])){
				$item['title'] = $item['feed_title'];
			}
			
			$before_item = $args['before_item'];
			if($this->router->request_uri == $item['uri']){
				$before_item = str_replace('>' , ' class="active">', $args['before_item']);
			}
			
			$the_item = $item['title'];
			
			if($args['link']){
				$the_item = '<a href="' . $item['uri'] . '">' . $item['title'] . '</a>';
			}
			
			echo $before_item . $the_item . $args['after_item'];
		}
	}
}