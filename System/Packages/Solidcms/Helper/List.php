<?php
class Solidcms_Helper_List extends Solidocs_Helper
{
	/**
	 * List
	 *
	 * @param string
	 * @param string
	 * @param array|string	Optional.
	 */
	public function generate($type, $key, $args = array()){
		$args = parse_args(array(
			'locale'		=> $this->locale,
			'limit'			=> 20,
			'order_by'		=> 'weight',
			'order'			=> 'ASC',
			'link'			=> true,
			'depth'			=> 0,
			'parent_id'		=> 0,
			'before_item'	=> '<li>',
			'after_item'	=> '</li>'
		), $args);
		
		switch($type){
			case 'channel':
			
				$this->db
					->select_from('solidcms_channel_item')
					->where(array(
						'solidcms_channel_item.channel' => $key
					));
			
			break;
			case 'type':
				
				$this->db
					->select_from('solidcms_content', 'solidcms_content.uri,solidcms_content.title,solidcms_content.list_title')
					->where(array(
						'content_type' => $key
					));
				
			break;
		}
		
		$this->db->where(array(
			'depth'		=> $args['depth'],
			'parent_id'	=> $args['parent_id']
		))->order($args['order_by'], $args['order'])->limit($args['limit'])->run();
		
		foreach($this->db->arr() as $item){
			if(!isset($item['url'])){
				$item['url'] = $item['uri'];
			}
			
			$before_item = $args['before_item'];
			if($this->router->request_uri == $item['url']){
				$before_item = str_replace('>' , ' class="active">', $args['before_item']);
			}
			
			$the_item = $item['title'];
			
			if($args['link']){
				$the_item = '<a href="' . $item['url'] . '">' . $item['title'] . '</a>';
			}
			
			echo $before_item . $the_item . $args['after_item'];
		}
	}
	
	/**
	 * Channel
	 *
	 * @param string
	 * @param array		Optional.
	 */
	public function channel($channel, $args = array()){
		$this->generate('channel', $channel, $args);
	}
	
	/**
	 * Type
	 *
	 * @param string
	 * @param array		Optional.
	 */
	public function type($type, $args = array()){
		$this->generate('type', $type, $args);
	}
}