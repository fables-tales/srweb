<?php

/*//{enable, server default} error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);


/* ====== CUSTOMISABLE DEFINES ======
 * Edit below to adapt to your system
 * ==================================
 */

/* The directory 'Smarty.class.php' can be found in */
define('SMARTY_DIR', 		'/usr/share/php/Smarty/');

/* The root of the website when hosted (Where you would navigate to
 * to find index.php) */
define('ROOT_URI', 		'http://zarquon/~chris/srweb/');

/* The allowed file extensions. Anything where no parsing is invoved,
 * can just be added. However, if parsing is required, then a smarty
 * plugin will need to be written. (But don't worry, it's very easy.) */
$ALLOWED_TYPES = array(
	'md',
	'html'
);

/* The pages that you wish to appear in the menu should be listed here.
 * Sub-directories need not be explicitly stated. By including a file
 * below, its inclusion in the menu is implied. */
$MENU_PAGES = array(
	'home', 
	'test',
	'dir',
	'dir/tester',
	'dir/tester2',
	'a/very/long/content/path',
	'mission'
);



/* ===================================
 * IF YOU ENJOY MILD PERIL, EDIT BELOW
 *    Don't say I didn't warn you!
 * ===================================
 */
//extract the current directory
define('ROOT_DIR',		dirname(__FILE__));
define('TEMPLATE_DIR', 		ROOT_DIR . '/templates');
define('COMPILED_TEMPLATE_DIR', ROOT_DIR . '/templates_compiled');
define('CACHE_DIR',		ROOT_DIR . '/cache');
define('CONTENT_DIR', 		ROOT_DIR . '/content');



?>
