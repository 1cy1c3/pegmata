<?php
/**
 * This class is responsible for the path finding 
 * based on the request to create the controller 
 * and so on.
 * 
 * @author Rune Krauss
 *
 */
class Router {
	/**
	 * Specific URI
	 *
	 * @var String
	 */
	protected $uri;
	/**
	 * Specific Controller
	 *
	 * @var Controller
	 */
	protected $controller;
	/**
	 * Specific action
	 *
	 * @var String
	 */
	protected $action;
	/**
	 * Specific parameters
	 *
	 * @var Array
	 */
	protected $params;
	/**
	 * Specific route
	 *
	 * @var String
	 */
	protected $route;
	/**
	 * Specific language
	 *
	 * @var String
	 */
	protected $language;
	/**
	 * Method prefix
	 *
	 * @var String
	 */
	protected $methodPrefix;
	/**
	 * Determines the controller, route, language, parameters
	 * and so on based on the specific request.
	 *
	 * @param String $uri
	 *        	URI
	 */
	public function __construct($uri) {
		// Decode an uri string, for example (the+code) -> (the code)
		$this->uri = urldecode ( trim ( $uri, '/' ) );
		
		// Get default values
		$routes = Config::get ( 'routes' );
		$this->route = Config::get ( 'defaultRoute' );
		$this->language = Config::get ( 'defaultLanguage' );
		$this->methodPrefix = isset ( $routes [$this->route] ) ? $routes [$this->route] : '';
		$this->controller = Config::get ( 'defaultController' );
		$this->action = Config::get ( 'defaultAction' );
		
		$uriParts = explode ( '?', $this->uri );
		
		// Get the path like /code/php/...
		$path = $uriParts [0];
		
		/*
		 * Save the controller, action and parameters in an array, for example
		 * /controller/action/param1/param2:
		 * Array
		 * (
		 * [0] => controller
		 * [1] => action
		 * [2] => param1
		 * [3] => param2
		 * )
		 */
		$pathParts = explode ( '/', $path );
		
		if (count ( $pathParts )) {
			// Get the route or language at first element
			if (in_array ( strtolower ( current ( $pathParts ) ), array_keys ( $routes ) )) {
				$this->route = strtolower ( current ( $pathParts ) );
				$this->methodPrefix = isset ( $routes [$this->route] ) ? $routes [$this->route] : '';
				array_shift ( $pathParts );
			} else if (in_array ( strtolower ( current ( $pathParts ) ), Config::get ( 'languages' ) )) {
				$this->language = strtolower ( current ( $pathParts ) );
				array_shift ( $pathParts );
			}
			// Get the controller
			if (current ( $pathParts )) {
				$this->controller = strtolower ( current ( $pathParts ) );
				array_shift ( $pathParts );
			}
			// Get the action
			if (current ( $pathParts )) {
				$this->action = strtolower ( current ( $pathParts ) );
				array_shift ( $pathParts );
			}
			// Get the parameters
			$this->params = $pathParts;
		}
	}
	/**
	 * Gets the URI.
	 *
	 * @return String URI
	 */
	public function getUri() {
		return $this->uri;
	}
	/**
	 * Gets the controller.
	 *
	 * @return Controller Controller
	 */
	public function getController() {
		return $this->controller;
	}
	/**
	 * Gets the action.
	 *
	 * @return String Action
	 */
	public function getAction() {
		return $this->action;
	}
	/**
	 * Gets the parameters.
	 *
	 * @return Array Parameters
	 */
	public function getParams() {
		return $this->params;
	}
	/**
	 * Gets the route.
	 *
	 * @return String Route
	 */
	public function getRoute() {
		return $this->route;
	}
	/**
	 * Gets the language.
	 *
	 * @return String Language
	 */
	public function getLanguage() {
		return $this->language;
	}
	/**
	 * Gets the method prefix.
	 *
	 * @return String Method prefix
	 */
	public function getMethodPrefix() {
		return $this->methodPrefix;
	}
}