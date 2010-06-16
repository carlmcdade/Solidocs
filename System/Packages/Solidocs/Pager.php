<?php
class Solidocs_Pager
{
	/**
	 * Num items
	 */
	public $total_rows;
	
	/**
	 * Page limit
	 */
	public $per_page = 10;
	
	/**
	 * Current page
	 */
	public $current_page = 1;
	
	/**
	 * Num pages
	 */
	public $num_pages = 1;
	
	/**
	 * Limit
	 */
	public $limit;
	
	/**
	 * Offset
	 */
	public $offset;
	
	/**
	 * Url
	 */
	public $url;
	
	/**
	 * Constructor
	 */
	public function __construct($total_rows = 0, $per_page = 10, $current_page = 1){
		$this->total_rows	= $total_rows;
		$this->page_limit	= $per_page;
		$this->current_page	= $current_page;
		
		$this->num_pages	= ceil($this->total_rows / $this->per_page);
		$this->offset		= floor(($this->current_page - 1) * $this->per_page);
		$this->limit		= ceil($this->current_page * $this->per_page);
	}
	
	/**
	 * Create links
	 */
	public function create_links($args = null){
		$args = parse_args(array(
			'before'		=> '<ul>',
			'after'			=> '</ul>',
			'before_item'	=> '<li>',
			'after_item'	=> '</li>',
			'previous_text'	=> 'Previous',
			'next_text'		=> 'Next'
		), $args);
		
		if($this->total_rows == 0 OR $this->per_page == 0 OR $this->num_pages == 1){
			return false;
		}
		
		echo $args['before'];
		
		if($this->current_page !== 1){
			echo $args['before_item'] . '<a href="' . str_replace(':page', $this->current_page - 1, $this->uri) . '">' . $args['previous_text'] . '</a>' . $args['after_item'];
		}
		
		$i = 1;
		
		while($i !== (int) $this->num_pages  + 1){
			echo $args['before_item'] . '<a href="' . str_replace(':page', $i, $this->uri) . '">' . $i . '</a>' . $args['after_item'];
			$i++;
		}
		
		if($this->current_page !== $this->num_pages){
			echo $args['before_item'] . '<a href="' . str_replace(':page', $this->current_page + 1, $this->uri) . '">' . $args['next_text'] . '</a>' . $args['after_item'];
		}
		
		echo $args['after'];
	}
}