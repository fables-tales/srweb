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


/* The pages that you wish to appear in the menu should be listed here.
 * There are two way to add a page to the menu:
 *
 *	1) simply add its path to the list. All parent directories
 * 	   will be included in the hierachy, and if not named before,
 * 	   will fall back to the page name (excl. ext.)
 *
 *	2) add its desired name mapped to its path to the list. i.e.
 *
 *	     'DIR NAME'  => 'dir/',
 *	     'SOME FILE' => 'dir/afile'
 *
 *	   will produce a hierachy (in text) as:
 *
 *	      DIR NAME
 *	      - SOME FILE
 *
 * Please note, however, that once a path has been given a nice title,
 * it cannot be changed. When adding menu items, work hierachically:
 * it makes it easier to read, and is also necessary to get all titles
 * to display correctly.
 *
 * Please also note that to name a directory, it needs a trailing slash.
 */
$MENU_PAGES = array(
//	TITLE/NAME		=>  PATH
//     =====================================================
	'Home' 			=> 'home',
	'Documentation \'09' 	=> 'dir/',
	'Motor Board Docs' 	=> 'dir/tester',
	'TESTER 2' 		=> 'dir/tester2/',
	'Another File' 		=> 'dir/tester2/anotherfile',
	'Mission Statement' 	=> 'mission',
	'Sponsors' 		=> 'sponsors',
	'Contact Us' 		=> 'contactus'
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
