<?php
/**
 * Base class of all data poses. All used models
 * extends this class.
 *
 * @author Rune Krauss
 *
 */
abstract class Model {
	/**
	 * Instance of the database
	 *
	 * @var Database
	 */
	protected $db;
	/**
	 * Instance of the logger
	 *
	 * @var Logger
	 */
	protected $logger;
	/**
	 * Initializes the database and logger.
	 */
	public function __construct() {
		$this->db = App::getDb ();
		$this->logger = Logger::getInstance ();
	}
}