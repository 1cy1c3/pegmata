<?php
/**
 * Handles all logging operations.
 * 
 * @author Rune Krauss
 *
 */
class Logger {
	/**
	 * Instance of this logger
	 *
	 * @var Logger
	 */
	protected static $instance = null;
	/**
	 * Name of the log file
	 *
	 * @var String
	 */
	private static $fileName = 'system.log';
	/**
	 * Gets the instance of this logger.
	 *
	 * @return Logger instance
	 */
	public static function getInstance() {
		if (null === self::$instance) {
			self::$instance = new self ();
		}
		return self::$instance;
	}
	/**
	 * Prevents the cloning of the logger.
	 */
	protected function __clone() {
	}
	/**
	 * Prevents the constructing of the logger.
	 */
	protected function __construct() {
	}
	/**
	 * Logs data in the log file based on a type and message.
	 *
	 * @param String $type
	 *        	Type
	 * @param String $msg
	 *        	Message
	 */
	public function log($type, $msg) {
		error_log ( '[' . date ( "d.m.Y - H:i" ) . '] ' . strtoupper ( $type ) . ': ' . $msg . "\n", 3, LOGS_PATH . DS . self::$fileName );
	}
}