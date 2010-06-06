<?php
class Solidocs_Router
{
	/**
	 * Request uri
	 */
	public $request_uri;
	
	/**
	 * Routes
	 */
	public $routes;
	
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
	 * Constructor
	 */
	public function __construct(){
		$this->request_uri	= $_SERVER['REQUEST_URI'];
		$this->segment		= explode('/', trim($this->request_uri, '/'));
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
	 * @param array
	 */
	public function set_route($route){
		$this->package		= ucfirst($route['package']);
		$this->controller	= ucfirst($route['controller']);
		$this->action		= $route['action'];
	}
	
	/**
	 * Route
	 */
	public function route(){
		foreach($this->routes as $route){
			$route = array_merge(array(
				'package'	=> 'Application',
				'locale'	=> Solidocs::$registry->locale
			),$route);
			
			if($route['locale'] !== Solidocs::$registry->locale){
				continue;
			}
			
			if($route['uri'] == '/*'){
				return $this->set_route($route);
			}
			
			$route_segment = explode('/', trim($route['uri'], '/'));
			
			if(count($route_segment) == count($this->segment) OR isset($route['default'])){
				$match = true;
				
				foreach($route_segment as $i => $segment){
					if(isset($route['default'])){
						if(isset($route['default'][trim($segment, ':')])){
							$this->segment[trim($segment, ':')] = $route['default'][trim($segment, ':')];
						}
						elseif(!isset($this->segment[$i])){
							$match = false;
						}
						else{
							$this->segment[trim($segment, ':')] = $this->segment[$i];
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
					return $this->set_route($route);
				}
			}
		}
	}
}