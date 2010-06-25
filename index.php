<?php

//get user configuration
require('config.inc.php');

//get smarty code
require(SMARTY_DIR . '/Smarty.class.php');

//get classes for constructing hierachical menu
require('classes/MenuItem.class.php');
require('classes/Menu.class.php');

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
	if (pageIsAllowed($_GET['page'])) $page = $_GET['page']; else $page = '404';
 else
	$page = 'home';

//append 'index' if there is a trailing slash
if (substr($page, -1) == '/') $page .= 'index';

//get type of page
$type = correctlyTypedFileExists($page);

if ($type){
	//make sure smarty knows
	$smarty->assign('type', $type);

} else if (correctlyTypedFileExists($page) . '/'){

	/* redirect -- tell the browser to use the trailing slash in
	 * the future. When a request looks like it's for a file, but
	 * the file doesn't exist, but there is a directory with the
	 * same name, redirect there */
	Header("HTTP/1.1 301 Moved Permanently");
	Header("Location: " . ROOT_URI . $page . '/');

} else {

	//get the type of the 404 page
	$page = '404';
	$smarty->assign('type', correctlyTypedFileExists($page));

}


//get ready to display the template
$smarty->assign('menu', constructMenuHierachy());
$smarty->assign('page', $page);
$smarty->assign('content_dir', CONTENT_DIR);
$smarty->assign('root_uri', ROOT_URI);

//display template
$smarty->display('index.tpl');













/*
 * Determines whether or not a particular file/dir exists
 * within the content dir. If it does, it returns its type
 * (file extension); if not, it returns false.
 */
function correctlyTypedFileExists($page){

	global $ALLOWED_TYPES;
	$p = $page;
	if (substr($p, -1) == '/'){$p .= 'index';}
	foreach ($ALLOWED_TYPES as $type){

		if (CONTENT_DIR . '/' . $p . '.' . $type === realpath(CONTENT_DIR . '/' . $p . '.' . $type))
			return $type;

	}//foreach

	return false;

}//correctlyTypedFileExists



/*
 * Determines whether or not a particular page can be viewed
 * (does it exist) returning a boolean value accordingly.
 */
function pageIsAllowed($page){

	global $ALLOWED_PAGES;
	return in_array($page, $ALLOWED_PAGES) || in_array($page . '/', $ALLOWED_PAGES);

}//pageIsAllowed



/*
 * Returns a list of allowed files/directories, recursively,
 * from the given $directory. Mmmmm... recursion.
 */
function getAllowedPages($directory) {
	$array_items = array();
	if ($handle = opendir($directory)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				if (is_dir($directory. "/" . $file)){
					$array_items = array_merge($array_items, getAllowedPages($directory. "/" . $file));	
					$pattern = '/^' . str_replace('/', '\/', CONTENT_DIR) . '\/(.+)$/';
					preg_match($pattern, $directory. "/" . $file, $matches);
					$array_items[] = $matches[1] . '/';
				}
				$file = $directory . "/" . $file;
				$pattern = '/^' . str_replace('/', '\/', CONTENT_DIR) . '\/(.+)\..+$/';
				preg_match($pattern, $file, $matches);
				$array_items[] = $matches[1];

			}
		}
		closedir($handle);
	}

	for ($i=0; $i<count($array_items); $i++)
		if ($array_items[$i] === NULL)
			unset($array_items[$i]);

	return $array_items;
}



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
	foreach($menu_pages as $path){
		$menu->addToHierachy($path, ROOT_URI);
	}

	return $menu;

}//constructMenuHeirachy


?>
