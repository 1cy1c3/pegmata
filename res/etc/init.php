<?php
/*
 * Load all required libraries and components
 */
function systemAutoloader($class) {
	$libsPath = ROOT . DS . 'libs' . DS . 'system' . DS . $class . '.php';
	$controllersPath = ROOT . DS . 'src' . DS . 'controllers' . DS . $class . '.php';
	$modelsPath = ROOT . DS . 'src' . DS . 'models' . DS . $class . '.php';
	if (file_exists ( $libsPath )) {
		require_once $libsPath;
	} else if (file_exists ( $controllersPath )) {
		require_once $controllersPath;
	} else if (file_exists ( $modelsPath )) {
		require_once $modelsPath;
	} else {
		Logger::getInstance ()->log ( 'ERROR', 'Failed to include class: ' . $class );
		throw new Exception ( 'Failed to include class: ' . $class );
	}
}
spl_autoload_register ( 'systemAutoloader' );