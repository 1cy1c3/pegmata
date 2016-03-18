<?php
/**
 * Base class of all logical operations. All used controllers 
 * extends this class.
 * 
 * @author Rune Krauss
 *
 */
abstract class Controller {
	/**
	 * Data regarding the view
	 *
	 * @var Array
	 */
	protected $data;
	/**
	 * Model regarding the controller
	 *
	 * @var Model $model
	 */
	protected $model;
	/**
	 * Parameters from the request
	 *
	 * @var Array $params
	 */
	protected $params;
	/**
	 * Logger of this system
	 *
	 * @var Logger $logger
	 */
	protected $logger;
	/**
	 * View regarding the controller
	 *
	 * @var View $view
	 */
	protected $view;
	/**
	 * Response regarding the header
	 *
	 * @var Response $response
	 */
	protected $response;
	/**
	 * Used languages
	 *
	 * @var Array $lang
	 */
	protected $lang;
	/**
	 * Specific session
	 *
	 * @var Session $session
	 */
	protected $session;
	/**
	 * Initializes the parameters and loads the language.
	 *
	 * @param Model $model
	 *        	Specific model
	 * @param View $view
	 *        	Specific view
	 * @param Response $response
	 *        	Response regarding the header
	 * @param Session $session
	 *        	Specific session
	 * @param Array $data
	 *        	Data from the view
	 */
	public function __construct($model, $view, $response, $session, $data = array()) {
		$this->model = $model;
		$this->view = $view;
		$this->data = $data;
		$router = App::getRouter ()->getParams ();
		$this->params = $router->getParams ();
		$this->logger = Logger::getInstance ();
		$langs [] = 'lang_' . $router->getLanguage () . '.php';
		$this->lang = $this->view->loadLanguage ( $langs );
		$this->response = $response;
		$this->session = $session;
	}
	/**
	 * Gets the data from the view.
	 *
	 * @return Array Data
	 */
	public function getData() {
		return $this->data;
	}
	/**
	 * Gets the specific model.
	 *
	 * @return Model Model
	 */
	public function getModel() {
		return $this->model;
	}
	/**
	 * Gets all parameters from the request.
	 *
	 * @return Array Parameters
	 */
	public function getParams() {
		return $this->params;
	}
}