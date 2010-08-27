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
require_once('classes/CacheWrapper.class.php');
define('MEMCACHE_TTL',		60 /*seconds*/);

function smarty_function_latestRSS($params, &$smarty)
{

	$feed_latest = NULL;

	//do some caching stuff
	$feed_latest = CacheWrapper::getCacheItem('latest_feed_content_', MEMCACHE_TTL, function(){

		return _latestRSS_getMostRecentFeedItem();

	});

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
