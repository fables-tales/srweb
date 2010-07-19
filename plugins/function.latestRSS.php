<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.latestRSS.php
 * Type:     function
 * Name:     latestRSS
 * Purpose:  Gets the most recent entry in an rss feed as HTML
 * -------------------------------------------------------------
 */
require_once('config.inc.php');
define('MEMCACHE_TTL',		600 /*seconds*/);

function smarty_function_latestRSS($params, &$smarty)
{

	$feed_latest = NULL;

	//check to see if cache module is useable
	if (extension_loaded('memcache')){

		//connect to memcached
		$memcache = new Memcache();
		if($memcache->pconnect(MEMCACHE_SERVER, MEMCACHE_PORT)){

			//does the most recent feed exist in the cache
			if (!($feed_latest = $memcache->get('latest_feed_content'))){
				//if not, make it so...
				$feed_latest = _latestRSS_getMostRecentFeedItem();
				$memcache->set('latest_feed_content', $feed_latest, 0, MEMCACHE_TTL);
			}

		} else
			return '<h2>Sad Face...</h2><p>Couldn\'t open a connection to memcache</p>';

	}//if extension_loaded

	//if cache wasn't useable, gracefully degrade to getting it each time
	if ($feed_latest === NULL)
		$feed_latest = _latestRSS_getMostRecentFeedItem();

	//and if that didn't work, leave it empty.
	if ($feed_latest === NULL)
		$feed_latest = '';

	return $feed_latest;

}

function _latestRSS_getMostRecentFeedItem(){

	require_once('createfeed.inc.php');
	$feed = getFeedContent();

	//strip out CDATA tags
	$feed = str_replace(array('<![CDATA[', ']]>'), '', $feed);

	//get the data for the first item (it has been sorted so the newest is at the top)
	$xml = new SimpleXMLElement($feed);
	$items = $xml->xpath('/rss/channel/item');

	//extract tags. Blank if it doesn't exist.
	$title = !empty($items[0]->title) ? htmlspecialchars((string)$items[0]->title) : '';
	$description = !empty($items[0]->description) ? htmlspecialchars((string)$items[0]->description) : '';
	$link = !empty($items[0]->link) ? htmlspecialchars((string)$items[0]->link) : '';

	return "<h2><a href='$link'>$title</a></h2><p>$description <a href=\"$link\">Read More...</a></p>";

}

?>





