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


$page = 'home';
if (isset($_GET['page'])){

 	if ( in_array($_GET['page'], $ALLOWED_PAGES) ){ //is page allowed

		//make sure file exists
		if ( file_exists(CONTENT_DIR . '/' . $_GET['page'] . '.md') 
	  	  || file_exists(CONTENT_DIR . '/' . $_GET['page'] . '.html') ){		
			$page = $_GET['page'];		
		
		} else {

			//no markdown or html for specified page (but it's in the array)
			$page = '404';
			//Header("Location: index.php?page=404");
		
		}//if-else file_exists

	} else {	

		//404 page not found
		$page = '404';
		//Header("Location: index.php?page=404");

	}//if-else in_array

} else {

	//page not specified, go home
	$page = 'home';

}//if-else isset




//display the index smarty template
$smarty->assign('page', $page);
$smarty->display('index.tpl');


?>
