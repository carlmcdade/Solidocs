<?php
/**
 * Router
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package		Solidocs
 * @author		Karl Roos <karlroos93@gmail.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.p
 */
class Solidocs_Router
{
	/**
	 * Request uri
	 */
	public $request_uri;
	
	/**
	 * Uri
	 */
	public $uri;
	
	/**
	 * Route
	 */
	public $route;
	
	/**
	 * Routes
	 */
	public $routes;
	
	/**
	 * Route key
	 */
	public $route_key;
	
	/**
	 * Route data
	 */
	public $route_data = 'html';
	
	/**
	 * Package
	 */
	public $package = 'Application';
	
	/**
	 * Controller
	 */
	public $controller = 'Index';
	
	/**
	 * Action
	 */
	public $action = '404';
	
	/**
	 * Segment
	 */
	public $segment = array();
	
	/**
	 * Output type
	 */
	public $output_type = 'html';
	
	/**
	 * Locale
	 */
	public $locale = 'en_GB';
	
	/**
	 * Constructor
	 */
	public function __construct(){
		$this->request_uri = $_SERVER['REQUEST_URI'];
		$this->uri = explode('?', $this->request_uri);
		$this->uri = $this->uri[0];
	}
	
	/**
	 * Set locale
	 */
	public function set_locale($locale){
		$this->locale = $locale;
	}
	
	/**
	 * Set routes
	 *
	 * @param array
	 */
	public function set_routes($routes){
		$this->routes = $routes;
	}
	
	/**
	 * Set route
	 *
	 * @param string
	 * @param array
	 */
	public function set_route($route_key, $route){
		$this->route		= $route;
		$this->package		= $route['package'];
		$this->controller	= $route['controller'];
		$this->action		= $route['action'];
		$this->route_key	= $route_key;
		
		// hack to remove segments with numeric keys
		foreach($this->segment as $key => $val){
			if(is_integer($key)){
				unset($this->segment[$key]);
			}
		}
	}
	
	/**
	 * Get route
	 *
	 * @return array
	 */
	public function get_route(){
		return $this->route;
	}
	
	/**
	 * Route
	 */
	public function route(){
		if(strpos($this->request_uri, '.')){
			$output_type = explode('.', $this->request_uri);
			
			if(in_array($output_type[count($output_type) - 1], array('html', 'xml', 'json', 'serialized'))){
				$this->output_type = $output_type[count($output_type) - 1];
				
				$this->request_uri = substr($this->request_uri, 0, strpos($this->request_uri, '.' . $this->output_type));
			}
		}
		
		$this->segment = explode('?', $this->request_uri);
		$this->segment = explode('/', trim($this->segment[0], '/'));
		
		foreach($this->routes as $route_key => $route){
			$route = array_merge(array(
				'package'		=> 'Application',
				'locale'		=> $this->locale,
			),$route);
			
			if($route['locale'] !== $this->locale){
				continue;
			}
			
			if($route['uri'] == '/*'){
				return $this->set_route($route_key, $route);
			}
			
			$route_segment = explode('/', trim($route['uri'], '/'));
			
			if(count($route_segment) == count($this->segment) OR isset($route['default'])){
				$match = true;
				
				foreach($route_segment as $i => $segment){
					if(!$match){
						continue;
					}
					
					if(isset($route['default'])){
						if(substr($segment, 0, 1) !== ':' AND $this->segment[$i] !== $segment){
							$match = false;
						}
						elseif(isset($this->segment[$i])){
							$this->segment[trim($segment, ':')] = $this->segment[$i];
						}
						elseif(isset($route['default'][trim($segment, ':')])){
							$this->segment[trim($segment, ':')] = $route['default'][trim($segment, ':')];
						}
						else{
							$match = false;
						}
					}
					elseif(substr($segment, 0, 1) == ':'){
						$this->segment[trim($segment, ':')] = $this->segment[$i];
					}
					elseif($segment !== $this->segment[$i]){
						$match = false;
					}
				}
				
				if($match){
					return $this->set_route($route_key, $route);
				}
			}
		}
	}
	
	/**
	 * Assemble
	 *
	 * @param string
	 * @param array		Optional.
	 * @return string
	 */
	public function assemble($key, $values = null, $query = null){
		if(!isset($this->routes[$key])){
			$uri = $key;
		}
		else{
			$uri = $this->routes[$key]['uri'];
			
			if($key == $this->route_key){
				$values = array_merge($this->segment, $values);
			}
		}
		
		if(isset($this->routes[$key]['default'])){
			$defaults = $this->routes[$key]['default'];
		}
		
		if(!is_array($values)){
			$values = array();
		}
		
		if(is_array($defaults)){
			$values = array_merge($defaults, $values);
		}
		
		if(count($values) !== 0){
			foreach($values as $key => $val){
				$uri = str_replace(':' . $key, $val, $uri);
			}
		}
		
		if(is_array($query)){
			$uri .= '?';
			
			foreach($query as $key => $val){
				$uri .= $key . '=' . $val . '&';
			}
			
			$uri = trim($uri, '&');
		}
		
		return $uri;
	}
}