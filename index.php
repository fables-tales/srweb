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


/*
 * Returns an ordered array (most prefered first) of languages
 * the client is happy with. If it's not set, then 'en' is the
 * default.
 */
function getOrderedLanguages(){

	if (!function_exists('apache_request_headers'))
		return array('en');

	$headers = apache_request_headers();

	if (!in_array('Accept-Language', array_keys($headers)))
		return array('en');

	$tags = explode(',', $headers['Accept-Language']);

	$pref_array = array();
	if (count($tags) > 0){

		$pattern = '/([A-Za-z]{2})(-[A-Za-z]{2})?(;q=[01]\.[0-9]+)?/';
		foreach ($tags as $tag){

			preg_match($pattern, $tag, $matches);
			$preference = $matches[3] != "" ? (float)str_replace(';q=', '', $matches[3]) : (float)1;
			$pref_array[$matches[1].$matches[2]] = $preference;

		}//foreach

		arsort($pref_array, SORT_NUMERIC);
		return array_keys($pref_array);

	} else {

		return array('en');

	}//if-else

}


?>
