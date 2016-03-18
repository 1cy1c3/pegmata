<?php
/**
 * This class is responsible for the configuration of useful
 * parameters in this system, for example the default controller, 
 * view and model.
 *
 * @author Rune Krauss
 *
 */
class Config {
	/**
	 * Settings of this system
	 *
	 * @var Array
	 */
	protected static $settings = array ();
	/**
	 * Gets the setting based on the key.
	 *
	 * @param String $key        	
	 * @return Config Config
	 */
	public static function get($key) {
		return isset ( self::$settings [$key] ) ? self::$settings [$key] : null;
	}
	/**
	 * Sets the setting based on the key and value.
	 *
	 * @param String $key        	
	 * @param String $val        	
	 */
	public static function set($key, $val) {
		self::$settings [$key] = $val;
	}
}