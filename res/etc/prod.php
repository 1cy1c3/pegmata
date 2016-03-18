<?php
/*
 * Set configuration parameters
 */
Config::set ( 'websiteName', 'Pegmata' );

Config::set ( 'languages', array (
		'en',
		'de' 
) );

Config::set ( 'routes', array (
		'default' => '',
		'admin' => 'admin_' 
) );

Config::set ( 'defaultRoute', 'layout' );
Config::set ( 'defaultLanguage', 'en' );
Config::set ( 'defaultController', 'pages' );
Config::set ( 'defaultAction', 'index' );
Config::set ( 'assets', ASSETS_PATH );

Config::set ( 'host', '127.0.0.1' );
Config::set ( 'user', '' );
Config::set ( 'password', '' );
Config::set ( 'database', 'pegmata' );
Config::set ( 'port', '3306' );

Config::set ( 'salt', '7709988956eb2fdc71aad2.35020583' );