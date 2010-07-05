<?php

ob_start();

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



if (isset($_GET['page']))

	if (pageIsAllowed($_GET['page'])) {

		$page = $_GET['page'];

	} elseif (pageIsAllowed($_GET['page'].'/')){

		//a file of that name doesn't exist, but a dir does.
		$page = $_GET['page'].'/';

		//perform a temporary redirect
		Header("HTTP/1.1 302 Found");
		Header("Location: " . ROOT_URI . $page);

	} else {

		//page not found/allowed
		$page = '404';
		Header("HTTP/1.1 404 Not Found");

	}//if-elseif-else pageIsAllowed

 else
	$page = 'home';

//append 'index' if there is a trailing slash
if (substr($page, -1) == '/') $page .= 'index';

if (CONTENT_DIR . '/' . $page === realpath(CONTENT_DIR . '/' . $page)){

	$content = new Content(CONTENT_DIR . '/' . $page);

} else {

	Header("HTTP/1.1 404 Not Found");
	$content = new Content(CONTENT_DIR . '/404');
}

$content->getParsedContent();
if ($content->getMeta('REDIRECT') != ""){
	Header("HTTP/1.1 302 Found");
	Header("Location: " . $content->getMeta('REDIRECT'));
}

//get ready to display the template
$smarty->assign('menu', constructMenuHierachy());
$smarty->assign('page', $page);
$smarty->assign('content_dir', CONTENT_DIR);
$smarty->assign('content', $content);
$smarty->assign('root_uri', ROOT_URI);

//display template
$smarty->display('index.tpl');

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
