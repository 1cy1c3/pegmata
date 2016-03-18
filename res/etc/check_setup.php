<?php

// Check PHP version
if (version_compare ( PHP_VERSION, '5.6.10', '<' )) {
	die ( 'This software requires PHP 5.6.10.' );
}

// Check module mod_rewrite
if (! in_array ( 'mod_rewrite', apache_get_modules () )) {
	die ( 'This software requires the module mod_rewrite.' );
}
