<?php

//get user configuration
require('config.inc.php');
require(SMARTY_DIR . '/Smarty.class.php');
require('classes/MenuItem.class.php');
require('classes/Menu.class.php');

//get instance of smarty
$smarty = new Smarty();

//$smarty->debugging = true;

//configure smarty
$smarty->template_dir = TEMPLATE_DIR;
$smarty->compile_dir = COMPILED_TEMPLATE_DIR;
$smarty->cache_dir = CACHE_DIR;



function correctlyTypedFileExists($page){

	global $ALLOWED_TYPES;
	$p = $page;
	if (substr($p, -1) == '/'){$p .= 'index';}
	foreach ($ALLOWED_TYPES as $type){

		if (CONTENT_DIR . '/' . $p . '.' . $type === realpath(CONTENT_DIR . '/' . $p . '.' . $type))
			return $type;

	}//foreach

	return false;

}




function pageIsAllowed($page){

	global $ALLOWED_PAGES;
	return in_array($page, $ALLOWED_PAGES);

}


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




function constructMenuHierachy(){

	global $MENU_PAGES;
	global $ALLOWED_PAGES;

	$menu = new Menu();

	$menu_pages = array_intersect($MENU_PAGES, $ALLOWED_PAGES);

	foreach($menu_pages as $path){
		$menu->addToHierachy($path, ROOT_URI);
	}

	return $menu;

}






$ALLOWED_PAGES = getAllowedPages(CONTENT_DIR);


if (isset($_GET['page'])){

	if (pageIsAllowed($_GET['page']))
		$page = $_GET['page'];
	else
		$page = '404';
	
} else {

	$page = 'home';

}//if isset

if (substr($page, -1) == '/'){$page .= 'index';}

//set type
$type = correctlyTypedFileExists($page);

if ($type){

	$smarty->assign('type', $type);

} else {

	$page = '404';
	$smarty->assign('type', correctlyTypedFileExists($page));

}

echo $_GET['page'];

//get ready to display the template
$smarty->assign('menu', constructMenuHierachy());
$smarty->assign('page', $page);
$smarty->assign('content_dir', CONTENT_DIR);
$smarty->assign('root_uri', ROOT_URI);
$smarty->display('index.tpl');


?>
