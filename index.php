<?php

//defines
define('SMARTY_DIR', 		dirname(__FILE__) . 'smarty');
define('TEMPLATE_DIR', 		SMARTY_DIR . '/templates');
define('COMPILED_TEMPLATE_DIR', SMARTY_DIR . '/templates_compiled');
define('CACHE_DIR', 		SMARTY_DIR . '/cache');
define('CONFIG_DIR', 		SMARTY_DIR . '/config');

//get instance of smarty
require(SMARTY_DIR . '/Smarty.class.php');
$smarty = new Smarty();

//configure smarty
$smarty->template_dir = TEMPLATE_DIR;
$smarty->compile_dir = COMPILED_TEMPLATE_DIR;
$smarty->cache_dir = CACHE_DIR;
$smarty->config_dir = CONFIG_DIR;

?>
