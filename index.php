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
require_once('classes/team_info.php');

//get class for getting a list of news articles
require('createfeed.inc.php');

require('classes/CacheWrapper.class.php');

//get instance of smarty
$smarty = new Smarty();

//$smarty->debugging = true;

//configure smarty
$smarty->template_dir = TEMPLATE_DIR;
$smarty->compile_dir = COMPILED_TEMPLATE_DIR;
$smarty->cache_dir = CACHE_DIR;

//get the page to serve (excl. language)
$page = getPage();

//get the prefered languages
$orderedLanguages = getOrderedLanguages();

//default language is en -- English
$language = 'en';

//use lowercase array keys for comparison (no mixed case issues then)
$accepted_languages = array_change_key_case($ACCEPTED_LANGUAGES, CASE_LOWER);

foreach($orderedLanguages as $l){

	if (isset($accepted_languages[strtolower($l)]) && file_exists(CONTENT_DIR . '/' . $accepted_languages[strtolower($l)] . '/' . $page)){
		$language = $accepted_languages[strtolower($l)];
		break;
	}

}//foreach

/* Some smarty variables that are accessible to all templates */
$smarty->assign('live_site', LIVE_SITE);

/*
 * Some pages need to be treated differently (they use a different template, for
 * example); this is handled here.
 */
if ($page == 'home'){

	$file = 'home-en';
	foreach ($orderedLanguages as $l){
		if (isset($accepted_languages[strtolower($l)]) && file_exists('templates/' . 'home-' . $accepted_languages[strtolower($l)] . '.tpl')){
			$file = 'home-' . $accepted_languages[strtolower($l)];
			break;
		}
	}

	$smarty->assign('side_menu', constructMenuHierachy());
	$smarty->assign('root_uri', ROOT_URI);
	$smarty->assign('base_uri', BASE_URI);
	$smarty->display($file . '.tpl');
	ob_end_flush();
	exit(0);

} elseif ($page == 'news/index'){

	$smarty->assign('p', isset($_GET['p']) ? $_GET['p'] : '1');
	$smarty->assign('root_uri', ROOT_URI);
	$smarty->assign('base_uri', BASE_URI);
	$smarty->display('news.tpl');
	ob_end_flush();
	exit(0);

} else {
	/* Pages that require the header/footer */

	$pageInDocs = preg_match('/docs\/.+/', $page);
	$pageInTeams = ($page != 'teams/index' && preg_match('/teams\/.+/', $page));
	$pageInNews = ($page != 'news/index' && preg_match('/news\/.+/', $page));

	$header_file = 'header-en.tpl';
	foreach ($orderedLanguages as $l){
		if (isset($accepted_languages[strtolower($l)]) && file_exists('templates/' . 'header-' . $accepted_languages[strtolower($l)] . '.tpl')){
			$header_file = 'header-' . $accepted_languages[strtolower($l)] . '.tpl';
			break;
		}
	}

	$footer_file = 'footer-en.tpl';
	foreach ($orderedLanguages as $l){
		if (isset($accepted_languages[strtolower($l)]) && file_exists('templates/' . 'footer-' . $accepted_languages[strtolower($l)] . '.tpl')){
			$footer_file = 'footer-' . $accepted_languages[strtolower($l)] . '.tpl';
			break;
		}
	}

	//get ready to display the template
	$smarty->assign('original', $language . '/' . $page);
	$smarty->assign('content_dir', CONTENT_DIR);
	$smarty->assign('root_uri', ROOT_URI);
	$smarty->assign('base_uri', BASE_URI);
	$smarty->assign('page_id', str_replace('/', '_', $page));
	$smarty->assign('header_file', $header_file);
	$smarty->assign('footer_file', $footer_file);

	if ($pageInTeams) {

		$team_id = substr($page, strrpos($page, '/')+1);
		$team = get_team_info($team_id);
		$smarty->assign('team', $team);

	} else {

		//the physical file to serve, including the language in the path
		$fileToServe = CONTENT_DIR . '/' . $language . '/' . $page;

		//do some caching stuff, generate the page if the cache is stale
		$content = CacheWrapper::getCacheItem('[page_content:' . $fileToServe . ':' . filemtime($fileToServe) . ']', 86400/*1 day*/, function(){

			global $fileToServe;
			$c = new Content($fileToServe);
			$c->getParsedContent();
			return $c;

		});

		//before we go ahead and serve it, see if we can use what the
		//user's browser has cached.
		if (function_exists('apache_request_headers') && !$pageInDocs && $content->getMeta('CONTENT_TYPE') != 'php'){

			$headers = apache_request_headers();

			//if the file hasn't changed since the client last saw it, send a 304
			if (isset($headers['If-Modified-Since'])
				&& (strtotime($headers['If-Modified-Since']) == filemtime($fileToServe))){

				header('Last-Modified: ' . gmdate('D, d M Y H:i:s',
					filemtime($fileToServe)).' GMT', false, $page == "404" ? 404 : 304);

				header('Connection: close');

			} else {

				//otherwise serve it
				header('Last-Modified: ' . gmdate('D, d M Y H:i:s',
					filemtime($fileToServe)).' GMT');

			}//if else isset if-mod-since

		}//if function_exists

		//if the file is a special redirection file, do the redirection
		if ($content->getMeta('REDIRECT') != ""){
			header("HTTP/1.1 302 Found");
			header("Location: " . $content->getMeta('REDIRECT'));
		}

		//make the content object accessible in the templates (used by a custom smarty plugin)
		$smarty->assign('content', $content);
	}

	if ($pageInDocs){
		$smarty->assign('docsNav', constructDocsNavHierarchy());
		$smarty->display('docs.tpl');
	} elseif ($pageInNews) {
		// Get links to prev/next news item
		$feed = getFeedContent();
		$feed = str_replace(array('<![CDATA[', ']]>'), '', $feed);
		$xml = new SimpleXMLElement($feed);
		$items = $xml->xpath('/rss/channel/item');

		// Construct the URL used in the RSS feed to identify the requested news item
		$thisNewsURL = BASE_URI . $page;

		$articleIndex = -1;

		foreach ($items as $key => $value) {
			if ($value->link == $thisNewsURL) {
				$articleIndex = $key;
				break;
			}
		}

		$prevNext = new stdClass();

		if ($articleIndex > 0) {
			// There's an article newer than this one
			$prevNext->next = new stdClass();
			$prevNext->next->title = $items[$articleIndex-1]->title;
			$prevNext->next->url = $items[$articleIndex-1]->link;
		}
		if ($articleIndex < count($items) - 1) {
			// There's an article older than this one
			$prevNext->prev = new stdClass();
			$prevNext->prev->title = $items[$articleIndex+1]->title;
			$prevNext->prev->url = $items[$articleIndex+1]->link;
		}

		$smarty->assign('prevNext', $prevNext);
		$smarty->assign('pubDate', strtotime($content->getPubDate()));

		$smarty->display('news-article.tpl');
	} elseif ($pageInTeams) {
		$smarty->display('team.tpl');
	} else
		$smarty->display('content.tpl');

	ob_end_flush();

}//if-else












/*
 * ===========================================================
 *                         FUNCTIONS
 * ===========================================================
 */

/*
 * Returns an ordered array (most prefered first) of languages
 * the client is happy with. If it's not set, then 'en' is the
 * default.
 *
 * For more information on this header, see the RFC:
 * http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4
 */
function getOrderedLanguages(){

	//check to see if we can get at the headers
	if (!function_exists('apache_request_headers'))
		return array('en');

	$headers = apache_request_headers();

	//check to see if Accept-Language header is present
	if (!in_array('Accept-Language', array_keys($headers)))
		return array('en');

	//get each of the language tags
	$tags = explode(',', $headers['Accept-Language']);

	$pref_array = array();
	if (count($tags) > 0){

		//get, by group, the following: language, country code, preference
		$pattern = '/([A-Za-z]{2}-?[A-Za-z]{0,2})(;q=[01]\.[0-9]+)?/';
		foreach ($tags as $tag){

			preg_match($pattern, $tag, $matches);

			//no 'q' preference === preference of 1
			$preference = array_key_exists(2, $matches) ? (float)str_replace(';q=', '', $matches[2]) : (float)1;
			$pref_array[$matches[1]] = $preference;

		}//foreach

		//sort thee array, in reverse numeric order, and return the keys (that's the language tag)
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


/*
 * Returns a list of allowed team pages.
 */
function getAllowedTeams() {
	$teams = get_team_list();
	$teams = array_map(function($t) {
	                   return 'teams/'.$t;
	                   },
	                   $teams);
	return $teams;
}


/*
 * Returns the page to serve.
 */
function getPage(){

	$page = 'home';

	//the 'default' directory is a symlink to the 'en' -- more explanatory
	$allowed_pages = getAllowedPages(CONTENT_DIR . '/default');
	$allowed_pages = array_merge($allowed_pages, getAllowedTeams());

	if (isset($_GET['page'])){

		//can we serve the page?
		if (in_array($_GET['page'], $allowed_pages)){

			$page = $_GET['page'];

		//is the request actually a directory?
		} elseif (in_array($_GET['page'] . '/', $allowed_pages)) {

			//redirect the browser to the more correct URL with trailing slash
			header('HTTP/1.1 302 Found');
			header('Location: ' . ROOT_URI . $_GET['page'] . '/');

		} else {

			//page not allowed / page not found -- respond with a 404
			header('HTTP/1.1 404 Not Found');
			$page = '404';
			log404();

		}//if-elseif-else

		//append 'index' if the 'page' requested is a directory
		if (substr($page, -1, 1) == '/')
			$page .= 'index';


	}//if isset

	return $page;

}//getPage



/*
 * Constructs a Menu (object) with a load of MenuItems (objects)
 * and to pass to the makemenu plugin (function.makemenu.php)
 * in the plugins/ dir. (For producing a ul/li-based menu).
 */
function constructMenuHierachy(){

	global $MENU_PAGES;
	$allowed_pages = getAllowedPages(CONTENT_DIR . '/default');

	$menu = new Menu();

	//ignore any menu page that doesn't exist
	$menu_pages = array_intersect($MENU_PAGES, $allowed_pages);

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



function constructDocsNavHierarchy(){

	$docsPages = getAllowedPages(CONTENT_DIR . '/default/docs');
	natcasesort($docsPages);
	$menu = new Menu();

	foreach($docsPages as $item){

		if (substr($item, -5, 5) == 'index')
			continue;

		$text = explode('/', $item);
		$text = $text[count($text)-1];
		$menu->addToHierachy($item, ROOT_URI, str_replace('_', ' ', $text));
	}

	return $menu;

}



function log404(){

	touch(LOG404_FILE);

	if (LOG404_ENABLED
		&& filesize(LOG404_FILE) < 2 << 20/*2MB*/
		&& isset($_SERVER['HTTP_REFERER'])
		&& strpos($_SERVER['HTTP_REFERER'], BASE_URI) !== false
		&& ! preg_match('/\/~.*/', $_SERVER['HTTP_REFERER'])){

		$f = fopen(LOG404_FILE, 'a');

		$line = '{/' . str_replace(BASE_URI, '', $_SERVER['HTTP_REFERER']) . '} was referring to {' . str_replace(ROOT_URI, '/', $_SERVER['REQUEST_URI']) . '} on ' . date('r') . "\n";

		fwrite($f, $line);

		fclose($f);

	}

}//log404

?>
