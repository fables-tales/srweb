<?php

//extract the current directory
define('ROOT_DIR',		dirname(__FILE__));

// Include the local config, ignoring any errors from it not existing.
@include_once(ROOT_DIR.'/local.config.inc.php');

function default_define($name, $value) {
    if (!defined($name)) {
        define($name, $value);
    }
}

/*//{enable, server default} error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* ====== CUSTOMISABLE DEFINES ======
 * Edit below to adapt to your system
 * ==================================
 */

/* This should always be set to false except on the live site */
default_define('LIVE_SITE',	false);

/* Whether the signups page (currently /schools/joining) shows a signup form,
 * or a message that the SR year is underway & to check back later */
default_define('ENABLE_SIGNUP', false);

/* Memcache(d) --
 * for the site to function, memcached is required (including the memcache)
 * PHP module. It is used to prevent needless processing for the RSS feed
 * and it's use. Without it, the feed will still work, but the latestRSS
 * smarty plugin will not. If you just start the memcache deamon (memcached)
 * then you probably won't need to change these settings
 */
default_define('MEMCACHE_ENABLED',	false);
default_define('MEMCACHE_SERVER', 	'127.0.0.1');
default_define('MEMCACHE_PORT',		11211);


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

	'Schools &amp; Colleges'=> 'schools/',
	'Competing Teams'=> 'teams/',
	'Competition'		=> 'schools/competition',
	'Joining'		=> 'schools/joining',
	'Documentation'		=> 'schools/docs/',
	'Forum'			=> 'forum/',
	'Kit'			=> 'schools/kit/',
	'Team Leaders'          => 'schools/team-leaders/',

	'Docs'			=> 'docs/',

	'Sponsors'		=> 'sponsors/',

	'About Us'		=> 'about/',
	'The Team'		=> 'about/team',
	'Media'			=> 'about/media',
	'Mission Statement'	=> 'about/mission',
	'Public Documents'	=> 'about/publicdocs',
	'Contact Us'		=> 'about/contactus',

	'News'			=> 'news/'
);


/*
 * An array to map standardised language tags (more on that in
 * a second) to the directory under which the content could be
 * found.
 *
 * A language tag is of the form 'a[[-b];q=c]'
 *
 * where:	'a' is an ISO-639-1 assigned language code;
 * 		'b' is an ISO 3166-1 alpha-2 assigned country code; and
 * 		'c' is a value between (and including) 0 and 1 as an
 * 		    indication of preference for the tag (with 0 being
 * 		    'do not use').
 *
 * Both 'b' and 'c' are optional. Below is case insensitive.
 *
 * The tag is sent by the client's browser in an 'Accept-Language'
 * header, so assuming the client has configured their browser, they
 * will be served their language's content if it exists. If it doesn't,
 * English (en) will be served instead.
 */
$ACCEPTED_LANGUAGES = array(
//	lANG. TAG	=>  LANG. DIR
//	=============================
	'en'		=> 'en',
	'en-gb'		=> 'en',
	'en-us'		=> 'en',
//	'fr'		=> 'fr'
);



/* ===================================
 * IF YOU ENJOY MILD PERIL, EDIT BELOW
 *    Don't say I didn't warn you!
 * ===================================
 */

/* The directory 'Smarty.class.php' can be found in */
default_define('SMARTY_DIR', 		'/usr/share/php/Smarty/');


/* The location of files relative to the directory this file is in */
default_define('ROOT_URI',  dirname($_SERVER['PHP_SELF']) != '/'
	? dirname($_SERVER['PHP_SELF']) . '/'
	: '/');

/* The root of the website when hosted (Where you would navigate to
 * to find index.php) */
$BASE_URI = !empty($_SERVER['HTTPS'])

	? 'https://' . $_SERVER['HTTP_HOST']
		. dirname($_SERVER['PHP_SELF']) . '/'

	: 'http://' . $_SERVER['HTTP_HOST']
		. dirname($_SERVER['PHP_SELF']) . '/';

default_define('BASE_URI', (substr($BASE_URI, -2, 2) == '//')
	? substr($BASE_URI, 0, -1)
	: $BASE_URI);

default_define('TEMPLATE_DIR', 		ROOT_DIR . '/templates');
default_define('COMPILED_TEMPLATE_DIR', ROOT_DIR . '/templates_compiled');
default_define('CACHE_DIR',		ROOT_DIR . '/cache');
default_define('CONTENT_DIR', 		ROOT_DIR . '/content');
default_define('TEAM_STATUS_DIR', 	ROOT_DIR . '/ide/settings/team-status');
// The following is used in both a template and a parsed page so ROOT_DIR
// is prepended automatically in the parsed page and manually in the template
default_define('TEAM_STATUS_IMG',	'images/teams');


//404 log stuff
default_define('LOG404_ENABLED',	true);
default_define('LOG404_FILE',		'/tmp/404log');

date_default_timezone_set("Europe/London");

?>
