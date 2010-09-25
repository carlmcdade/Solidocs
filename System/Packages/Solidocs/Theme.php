<?php
/**
 * Theme
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php
 */
class Solidocs_Theme extends Solidocs_Base
{
	/**
	 * Use theme
	 */
	public $use_theme = true;
	
	/**
	 * Theme
	 */
	public $theme = 'Default';
	
	/**
	 * Theme files
	 */
	public $theme_files = array('index');
	
	/**
	 * Layout
	 */
	public $layout = 'default';
	
	/**
	 * Layouts
	 */
	public $layouts = array('default' => array('regions' => array('content')));
	
	/**
	 * Regions
	 */
	public $regions = array('content' => 'Content');
	
	/**
	 * Region items
	 */
	public $region_items = array();
	
	/**
	 * Title base
	 */
	public $title_base = null;
	
	/**
	 * Title parts
	 */
	public $title_parts = array();
	
	/**
	 * Title default
	 */
	public $title_default = '';
	
	/**
	 * Title separator
	 */
	public $title_separator;
	
	/**
	 * Title reverse
	 */
	public $title_reverse = true;
	
	/**
	 * Default description
	 */
	public $default_description = '';
	
	/**
	 * Default keywords
	 */
	public $default_keywords = '';
	
	/**
	 * Head jquery
	 */
	public $head_jquery = false;
	
	/**
	 * Meta
	 */
	public $meta = array();
	
	/**
	 * js
	 */
	public $js = array();
	
	/**
	 * CSS
	 */
	public $css = array();
	
	/**
	 * Style
	 */
	public $style = array();
	
	/**
	 * Script
	 */
	public $script = array();
	
	/**
	 * Body class
	 */
	public $body_class = '';
	
	/**
	 * Call magic method
	 *
	 * @param string
	 * @param array
	 */
	public function __call($method, $params){
		return $this->output->helper($method, $params);
	}
	
	/**
	 * Set theme
	 *
	 * @param string
	 */
	public function set_theme($theme){
		$this->theme = $theme;
	}
	
	/**
	 * Set layout
	 *
	 * @param string
	 */
	public function set_layout($layout){
		$this->layout = $layout;
	}
	
	/**
	 * Add file
	 *
	 * @param string
	 */
	public function add_theme_file($file){
		array_unshift($this->theme_files, $file);
	}
	
	/**
	 * Add title
	 *
	 * @param string
	 */
	public function add_title($part){
		$this->title_parts[] = $part;
	}
	
	/**
	 * Add region item
	 *
	 * @param string
	 * @param string
	 */
	public function add_region_item($region, $content){
		$this->region_items[$region][] = $content;
	}
	
	/**
	 * Prepare
	 */
	public function prepare(){
		// Prepare the theme constants
		define('THEME', MEDIA . '/Theme/' . $this->theme);
		define('THEME_WWW', str_replace(ROOT, '', THEME));
	}
	
	/**
	 * Render
	 *
	 * @return string
	 */
	public function render(){
		// Check for theme.ini
		if($this->config->file_exists(THEME . '/theme')){
			$config = $this->config->load_file(THEME . '/theme', true);
			
			if(isset($config['layouts'])){
				$this->layouts = $config['layouts'];
			}
			
			if(isset($config['regions'])){
				$this->regions = $config['regions'];
			}
		}
		
		Solidocs::do_action('pre_theme_render');
		
		// Loop possible theme files
		foreach($this->theme_files as $file){
			if(isset($theme_file)){
				continue;
			}
			
			if(file_exists(THEME . '/' . $file . '.php')){
				$theme_file = THEME . '/' . $file . '.php';
			}
		}
		
		// No theme file found
		if(!isset($theme_file)){
			throw new Exception('No theme file could be found in "' . THEME . '".');
		}
		
		ob_start();
		include($theme_file);
		
		Solidocs::do_action('post_theme_render');
		
		return Solidocs::apply_filter('theme_render', ob_get_clean());
	}
	
	/**
	 * Render layout
	 */
	public function render_layout(){
		$layout_file = THEME . '/' . $this->layout . '.layout.php';
		
		// Check for layout file
		if(file_exists($layout_file)){	
			include($layout_file);
		}
		else{
			// Display the content and wrap in a div
			echo '<div id="content">' . $this->output->render_content(true) . '</div>';
		}
	}
	
	/**
	 * Render content
	 */
	public function render_content(){
		echo $this->output->render_content();
	}
	
	/** 
	 * Render region
	 *
	 * @param string
	 */
	public function render_region($region){
		// Check if the region exists
		if(!isset($this->regions[$region])){
			throw new Exception('The region "' . $region . '" is not defined');
			return false;
		}
		
		if(is_array($this->region_items[$region])){
			// Loop region items and display
			foreach(Solidocs::apply_filter('region.' . $region, $this->region_items[$region]) as $content){
				echo $content;
			}
		}
	}
	
	/**
	 * Theme part
	 *
	 * @param string
	 */
	public function theme_part($part){
		include(THEME . '/' . $part . '.php');
	}
	
	/**
	 * Theme header
	 */
	public function theme_header(){
		$this->theme_part('header');
	}
	
	/**
	 * Theme footer
	 */
	public function theme_footer(){
		$this->theme_part('footer');
	}
	
	/**
	 * Title
	 *
	 * @param string		Optional.
	 * @param string|array	Optional.
	 * @param string		Optional.
	 * @param bool			Optional.
	 * @return string
	 */
	public function title($title_base = null, $title_parts = null, $title_default = '', $title_separator = ' - ', $title_reverse = null){
		// Retrieve properties from this object if they arn't passed with the method
		if($title_base == null){
			$title_base = $this->title_base;
		}
		
		if($this->title_separator !== null){
			$title_separator = $this->title_separator;
		}
		
		if($title_parts == null){
			$title_parts = $this->title_parts;
		}
		
		if($title_reverse == null){
			$title_reverse = $this->title_reverse;
		}
		
		// Check if there arn't any title parts
		if(count($title_parts) == 0){
			if($this->title_default !== ''){
				$title_default = $this->title_default;
			}
			
			// Add default title if it isn't empty
			if(strlen($title_default) !== 0){
				$title_parts[] = $title_default;
			}
		}
		
		// Check if there's a title base
		if(!empty($title_base)){
			array_unshift($title_parts, $title_base);
		}
		
		// Reverse title?
		if($title_reverse){
			$title_parts = array_reverse($title_parts);
		}
		
		// Assemble the title
		return implode($title_separator, $title_parts);		
	}
	
	/**
	 * Set jquery
	 *
	 * @param bool
	 */
	public function set_jquery($flag){
		$this->head_jquery = $flag;
	}
	
	/**
	 * Add meta
	 *
	 * @param string
	 * @param string
	 */
	public function add_meta($name, $content){
		$this->meta[$name] = $content;
	}
	
	/**
	 * Remove meta
	 *
	 * @param string
	 */
	public function remove_meta($name){
		if(isset($this->meta[$name])){
			unset($this->meta[$name]);
		}
	}
	
	/**
	 * Add js
	 *
	 * @param string
	 */
	public function add_js($src){
		if(!in_array($src, $this->js)){
			$this->js[] = $src;
		}
	}
	
	/**
	 * Remove js
	 *
	 * @param string
	 */
	public function remove_js($src){
		if(in_array($src, $this->js)){
			unset($this->js[array_search($src, $this->js)]);
		}
	}
	
	/**
	 * Add css
	 *
	 * @param string
	 */
	public function add_css($href){
		if(!in_array($href, $this->css)){
			$this->css[] = $href;
		}
	}
	
	/**
	 * Remove css
	 *
	 * @param string
	 */
	public function remove_css($href){
		if(in_array($href, $this->css)){
			unset($this->css[array_search($href, $this->css)]);
		}
	}
	
	/**
	 * Add style
	 *
	 * @param string
	 */
	public function add_style($style){
		$this->style[] = $style;
	}
	
	/**
	 * Add script
	 *
	 * @param string
	 */
	public function add_script($script){
		$this->script[] = $script;
	}
	
	/**
	 * Head
	 *
	 * @param array		Optional.
	 * @param bool		Optional.
	 * @return string
	 */
	public function head($args = array(), $return = false){
		// Arguments
		$args = array_merge(array(
			'title'		=> true,
			'meta'		=> true,
			'js'		=> true,
			'script'	=> true,
			'css'		=> true,
			'style'		=> true
		), $args);
		
		// Head jQuery
		if($this->head_jquery){
			array_unshift($this->js, 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js');
		}
		
		// Default meta description
		if(!empty($this->default_description)){
			if(!isset($this->meta['description'])){
				$this->add_meta('description', $this->default_description);
			}
		}
		
		// Default meta keywords
		if(!empty($this->default_keywords)){
			if(!isset($this->meta['keywords'])){
				$this->add_meta('keywords', $this->default_keywords);
			}
		}
		
		$output	= '';
		
		// Loop through the arguments
		foreach($args as $item => $flag){
			if($flag == true){
				// Title
				if($item == 'title'){
					$output .= '<title>' . $this->title() . '</title>';
					continue;
				}
				
				// Empty
				if(count($this->$item) == 0){
					continue;
				}
				
				// Loop items
				foreach($this->$item as $key => $val){
					// Remove the ROOT path from the value
					$val = str_replace(ROOT, '', $val);
					
					// Render item
					switch($item){
						case 'meta':
							$output .= '<meta name="' . $key . '" content="' . $val . '" />' . "\n";
						break;
						
						case 'js':
							$output .= '<script type="text/javascript" src="' . $val . '"></script>' . "\n";
						break;
						
						case 'css':
							$output .= '<link rel="stylesheet" type="text/css" href="' . $val . '" />' . "\n";
						break;
						
						case 'script':
							$output .= '<script type="text/javascript">' . $val . '</script>' . "\n";
						break;
						
						case 'style':
							$output .= '<style type="text/css">'. $val . '</style>' . "\n";
						break;
					}
				}
			}
		}
		
		// Display output
		if($return){
			return $output;
		}
		
		echo $output;
	}
	
	/**
	 * Body class
	 *
	 * @return string
	 */
	public function body_class(){
		if(!empty($this->body_class)){
			echo ' class="' . $this->body_class . '"';
		}
	}
}