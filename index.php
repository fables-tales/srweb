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




function correctlyTypedFileExists($page){

	global $ALLOWED_TYPES;
	
	foreach ($ALLOWED_TYPES as $type){

		if (CONTENT_DIR . '/' . $page . '.' . $type === realpath(CONTENT_DIR . '/' . $page . '.' . $type))
			return $type;

	}//foreach

	return false;

}




function pageIsAllowed($page){

	global $ALLOWED_PAGES;
	return in_array($page, $ALLOWED_PAGES);

}


function constructMenuHierachy(){

	global $MENU_PAGES;
	global $ALLOWED_PAGES;

	$menu = new Menu();

	$menu_pages = array_intersect($MENU_PAGES, $ALLOWED_PAGES);

	foreach($menu_pages as $path){
		$menu->addToHierachy($path);
	}

	return $menu;

}









if (isset($_GET['page'])){

	if (pageIsAllowed($_GET['page']))
		$page = $_GET['page'];
	else
		$page = '404';
	
} else {

	$page = 'home';

}//if isset



//set type
$type = correctlyTypedFileExists($page);

if ($type){

	$smarty->assign('type', $type);

} else {

	$page = '404';
	$smarty->assign('type', correctlyTypedFileExists($page));

}


//get ready to display the template
$smarty->assign('menu', constructMenuHierachy());
$smarty->assign('page', $page);
$smarty->assign('content_dir', CONTENT_DIR);
$smarty->display('index.tpl');


?>
