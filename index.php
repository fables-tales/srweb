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
			if (substr($file, 0, 1) != '.') {

				if (is_dir($directory. "/" . $file)){

					//get the listing for the directory as well
					$array_items = array_merge($array_items, getAllowedPages($directory. "/" . $file));

					//get the bit of path after the content dir
					$pattern = '/^' . str_replace('/', '\/', CONTENT_DIR . '/default') . '\/(.+)$/';
					preg_match($pattern, $directory. "/" . $file, $matches);
					$array_items[] = $matches[1] . '/';

					continue;

				}//if is_dir

				$file = $directory . "/" . $file;

				//ignore the extension fof the file paths, and get just the bit after 'content/'
				$pattern = '/^' . str_replace('/', '\/', CONTENT_DIR . '/default') . '\/(.+)$/';
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



?>
