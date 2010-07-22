<?php
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
	 * Title separator
	 */
	public $title_separator = ' - ';
	
	/**
	 * Title base after
	 */
	public $title_base_after = false;
	
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
	public function __call($called, $params){
		return $this->output->__call($called, $params);
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
	 * Add title part
	 *
	 * @param string
	 */
	public function add_title_part($part){
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
	 * Render
	 *
	 * @return string
	 */
	public function render(){
		define('THEME', MEDIA . '/Theme/' . $this->theme);
		define('THEME_WWW', str_replace(ROOT, '', THEME));
		
		if($this->config->file_exists(THEME . '/theme')){
			$config = $this->config->load_file(THEME . '/theme', true);
			
			if(isset($config['layouts'])){
				$this->layouts = $config['layouts'];
			}
			
			if(isset($config['regions'])){
				$this->regions = $config['regions'];
			}
		}
		
		foreach($this->theme_files as $file){
			if(isset($theme_file)){
				continue;
			}
			
			if(file_exists(THEME . '/' . $file . '.php')){
				$theme_file = THEME . '/' . $file . '.php';
			}
		}
		
		if(!isset($theme_file)){
			throw new Exception('No theme file could be found in "' . THEME . '".');
		}
		
		ob_start();
		include($theme_file);
		return ob_get_clean();
	}
	
	/**
	 * Render layout
	 */
	public function render_layout(){
		$layout_file = THEME . '/' . $this->layout . '.layout.php';
		
		if(file_exists($layout_file)){	
			include($layout_file);
		}
		else{
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
		if(is_array($this->region_items[$region])){
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
	public function title($title_base = null, $title_parts = null, $title_separator = ' - ', $title_base_after = false){
		if($this->title_base !== null){
			$title_base = $this->title_base;
		}
		
		if(count($this->title_parts) !== 0){
			$title_parts = $this->title_parts;
		}
		
		if(!is_array($title_parts)){
			if(!empty($title_parts)){
				$title_parts = array($title_parts);
			}
			else{
				$title_parts = array();
			}
		}
		
		if($this->title_separator == null){
			$title_separator = $this->title_separator;
		}		
		
		if($this->title_base_after == false AND $title_base_after == false){
			array_unshift($title_parts, $title_base);
		}
		else{
			$title_parts[] = $title_base;
		}
		
		return implode($title_separator, $title_parts);		
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
		$this->js[] = $src;
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
		$this->css[] = $href;
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
		$defaults = array(
			'title'		=> true,
			'meta'		=> true,
			'js'		=> true,
			'script'	=> true,
			'css'		=> true,
			'style'		=> true
		);
		
		$args	= array_merge($defaults, $args);
		$output	= '';
		
		foreach($args as $item => $flag){
			if($flag == true){
				if($item == 'title'){
					$output .= $this->title();
					continue;
				}
				
				if(count($this->$item) == 0){
					continue;
				}
				
				foreach($this->$item as $key => $val){
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