<?php

/*
//{enable, server default} error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
*/

//extract the current directory
define('ROOT_DIR',		dirname(__FILE__));

//customisable defines
define('SMARTY_DIR', 		'/usr/share/php/Smarty/');
define('TEMPLATE_DIR', 		ROOT_DIR . '/templates');
define('COMPILED_TEMPLATE_DIR', ROOT_DIR . '/templates_compiled');
define('CONTENT_DIR', 		ROOT_DIR . '/content');

$ALLOWED_PAGES = Array(
	'home',
	'404',
	'test', 
	'dir/tester'
);

?>
