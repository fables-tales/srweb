<?php

//get user configuration
require('config.inc.php');

//get instance of smarty
require(SMARTY_DIR . '/Smarty.class.php');
$smarty = new Smarty();

//$smarty->debugging = true;

//configure smarty
$smarty->template_dir = TEMPLATE_DIR;
$smarty->compile_dir = COMPILED_TEMPLATE_DIR;


function correctlyTypedFileExists($page){

	$ALLOWED_TYPES = Array('md', 'html');
	
	foreach ($ALLOWED_TYPES as $type){

		if (file_exists(CONTENT_DIR . '/' . $page . '.' . $type))
			return $type;

	}//foreach

	return false;

}


function pageIsAllowed($page){

	global $ALLOWED_PAGES;
	return in_array($page, $ALLOWED_PAGES);

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





//display the index smarty template
$smarty->assign('page', $page);
$smarty->assign('content_dir', CONTENT_DIR);
$smarty->display('index.tpl');


?>
