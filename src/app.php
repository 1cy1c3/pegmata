<?php

// Include setup
require_once ROOT . DS . 'res' . DS . 'etc' . DS . 'check_setup.php';

// Include vendor
require_once ROOT . DS . 'libs' . DS . 'vendor' . DS . 'autoload.php';

// System Autoloader
require_once ROOT . DS . 'res' . DS . 'etc' . DS . 'init.php';

// Include main settings
require_once ROOT . DS . 'res' . DS . 'etc' . DS . 'prod.php';

session_start ();

try {
	App::run ();
} catch ( Exception $e ) {
	echo $e->getMessage ();
}