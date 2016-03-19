<?php
/**
 * This class is used for the initialization of all 
 * components in this system, so controllers, models, 
 * views and so on.
 *
 * @author Rune Krauss
 *
 */
class App {
	/**
	 * Router of this system
	 *
	 * @var Router
	 */
	protected static $router;
	/**
	 * Database of this system
	 *
	 * @var Database
	 */
	protected static $db;
	/**
	 * Runs this application.
	 * First, It initializes the router,
	 * the database and other components. Afterwards, determines
	 * the view, model and controller based on the identified values.
	 *
	 * @throws Exception If the method of the controller does not exist.
	 */
	public static function run() {
		self::$router = new Router ( $_SERVER ['REQUEST_URI'] );
		
		self::$db = new Database ( Config::get ( 'host' ), Config::get ( 'user' ), Config::get ( 'password' ), Config::get ( 'database' ), Config::get ( 'port' ) );
		
		$controllerClass = ucfirst ( self::$router->getController () ) . 'Controller';
		$controllerMethod = strtolower ( self::$router->getMethodPrefix () ) . self::$router->getAction ();
		
		$session = new Session ();
		$response = new Response ();
		
		$response->csp ();
		$response->hsts ();
		$response->nosniff ();
		$response->xframe ();
		$response->xss ();
		
		$route = self::$router->getRoute ();
		if ($route == 'admin' && $session->get ( 'role' ) != 'admin') {
			if ($controllerMethod != 'admin_login') {
				$response->redirect ( '/admin/users/login/' );
			}
		}
		
		$modelName = ucfirst ( self::$router->getController () );
		$model = new $modelName ();
		
		$view = new View ( VIEWS_PATH . DS . self::getRouter ()->getController () . DS, LANG_PATH . DS . self::$router->getLanguage () . DS );
		$view->load ( self::$router->getMethodPrefix () . self::$router->getAction () . '.html' );
		
		// Call the method in the controller
		$controller = new $controllerClass ( $model, $view, $response, $session );
		
		if (method_exists ( $controller, $controllerMethod )) {
			$controller->$controllerMethod ();
		} else {
			Logger::getInstance ()->log ( 'ERROR', 'The method ' . $controllerMethod . ' of class ' . $controllerClass . ' does not exist.' );
			throw new Exception ( 'The method ' . $controllerMethod . ' of class ' . $controllerClass . ' does not exist.' );
		}
		$tpl = new View ( VIEWS_PATH . DS, LANG_PATH . DS . self::$router->getLanguage () . DS );
		$tpl->load ( $route . '.html' );
		$langs [] = 'lang_' . App::getRouter ()->getLanguage () . '_' . $route . '.php';
		$lang = $tpl->loadLanguage ( $langs );
		$templateObject = ucfirst ( $route );
		$template = new $templateObject ( $tpl, $view, $lang, $session );
	}
	/**
	 * Gets the router of this system.
	 *
	 * @return Router Router
	 */
	public static function getRouter() {
		return self::$router;
	}
	/**
	 * Gets the database instance of this system.
	 *
	 * @return Database instance
	 */
	public static function getDb() {
		return self::$db;
	}
}