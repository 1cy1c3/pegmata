<?php
define ( 'DS', DIRECTORY_SEPARATOR );
define ( 'ROOT', dirname ( dirname ( __FILE__ ) ) );
define ( 'VIEWS_PATH', ROOT . DS . 'res' . DS . 'views' );
define ( 'LOGS_PATH', ROOT . DS . 'res' . DS . 'logs' );
define ( 'LANG_PATH', ROOT . DS . 'locales' );
define ( 'ASSETS_PATH', '/assets' );
require_once ROOT . DS . 'src' . DS . 'app.php';
