<?php

if (!ob_start('ob_gzhandler')) ob_start();

//get user configuration
require('config.inc.php');

//get smarty code
require(SMARTY_DIR . '/Smarty.class.php');

//get classes for constructing hierachical menu
require('classes/MenuItem.class.php');
require('classes/Menu.class.php');

//get class from extracting metadata and content
require('classes/Content.class.php');

//get instance of smarty
$smarty = new Smarty();

//$smarty->debugging = true;

//configure smarty
$smarty->template_dir = TEMPLATE_DIR;
$smarty->compile_dir = COMPILED_TEMPLATE_DIR;
$smarty->cache_dir = CACHE_DIR;

//get the allowed pages by traversing the content dir
$ALLOWED_PAGES = getAllowedPages(CONTENT_DIR);



if (isset($_GET['page']) && ($_GET['page'] != 'home')) {

	if (pageIsAllowed($_GET['page'])) {

		$page = $_GET['page'];

	} elseif (pageIsAllowed($_GET['page'].'/')){

		//a file of that name doesn't exist, but a dir does.
		$page = $_GET['page'].'/';

		//perform a temporary redirect
		Header("HTTP/1.1 302 Found");
		Header("Location: " . ROOT_URI . $page);

	} elseif ($page != 'home'){

		//page not found/allowed
		$page = '404';
		Header("HTTP/1.1 404 Not Found");

	}//if-elseif-else pageIsAllowed

} else {

	//home page
	$smarty->assign('side_menu', constructMenuHierachy());
	$smarty->assign('root_uri', ROOT_URI);
	$smarty->display('home.tpl');
	ob_end_flush();
	exit(0);
}





//append 'index' if there is a trailing slash
if (substr($page, -1) == '/') $page .= 'index';

if (CONTENT_DIR . '/' . $page === realpath(CONTENT_DIR . '/' . $page)){

	if (function_exists('apache_request_headers')){

		$headers = apache_request_headers();

		if (isset($headers['If-Modified-Since'])
			&& (strtotime($headers['If-Modified-Since']) == filemtime(CONTENT_DIR . '/' . $page))){

			Header('Last-Modified: ' . gmdate('D, d M Y H:i:s',
				filemtime(CONTENT_DIR . '/' . $page)).' GMT', true, 304);

			Header('Connection: close');

		} else {

			Header('Last-Modified: ' . gmdate('D, d M Y H:i:s',
				filemtime(CONTENT_DIR . '/' . $page)).' GMT', true, 200);

		}//if else isset if-mod-since

	}//apache headers exists

	$content = new Content(CONTENT_DIR . '/' . $page);

} else
	$content = new Content(CONTENT_DIR . '/404');


$content->getParsedContent();

if ($content->getMeta('REDIRECT') != ""){
	Header("HTTP/1.1 302 Found");
	Header("Location: " . $content->getMeta('REDIRECT'));
}

$smarty->assign('content', $content);


//get ready to display the template
$smarty->assign('page', $page);
$smarty->assign('content_dir', CONTENT_DIR);
$smarty->assign('root_uri', ROOT_URI);

//display contnet template
$smarty->display('content.tpl');

ob_end_flush();








/*
 * Determines whether or not a particular page can be viewed
 * (does it exist) returning a boolean value accordingly.
 */
function pageIsAllowed($page){

	global $ALLOWED_PAGES;
	return in_array($page, $ALLOWED_PAGES);

}//pageIsAllowed



/*
 * Returns a list of allowed files/directories, recursively,
 * from the given $directory. Mmmmm... recursion.
 */
function getAllowedPages($directory) {

	$array_items = array();

	if ($handle = opendir($directory)) {

		//read each item (file/dir) in $directory
		while (false !== ($file = readdir($handle))) {

			//ignore . and ..
			if ($file != "." && $file != "..") {

				if (is_dir($directory. "/" . $file)){

					//get the listing for the directory as well
					$array_items = array_merge($array_items, getAllowedPages($directory. "/" . $file));

					//get the bit of path after the content dir
					$pattern = '/^' . str_replace('/', '\/', CONTENT_DIR) . '\/(.+)$/';
					preg_match($pattern, $directory. "/" . $file, $matches);
					$array_items[] = $matches[1] . '/';

					continue;

				}//if is_dir

				$file = $directory . "/" . $file;

				//ignore the extension fof the file paths, and get just the bit after 'content/'
				$pattern = '/^' . str_replace('/', '\/', CONTENT_DIR) . '\/(.+)$/';
				preg_match($pattern, $file, $matches);
				$array_items[] = $matches[1];

			}//if (not . or ..)

		}//while

		closedir($handle);

	}//if opened

	//remove spurious NULLs
	for ($i=0; $i<count($array_items); $i++)
		if ($array_items[$i] === NULL)
			unset($array_items[$i]);

	return $array_items;

}//getAllowedPages



/*
 * Constructs a Menu (object) with a load of MenuItems (objects)
 * and to pass to the makemenu plugin (function.makemenu.php)
 * in the plugins/ dir. (For producing a ul/li-based menu).
 */
function constructMenuHierachy(){

	global $MENU_PAGES;
	global $ALLOWED_PAGES;

	$menu = new Menu();

	//ignore any menu page that doesn't exist
	$menu_pages = array_intersect($MENU_PAGES, $ALLOWED_PAGES);

	//add each to the hierachy
	foreach (array_keys($menu_pages) as $index){

		$path = $menu_pages[$index];

		if (gettype($index) == 'string'){
			$menu->addToHierachy($path, ROOT_URI, $index);
		} else {
			$menu->addToHierachy($path, ROOT_URI);
		}

	}

	return $menu;

}//constructMenuHeirachy


?>
