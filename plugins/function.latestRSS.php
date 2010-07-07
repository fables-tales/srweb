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

define('MEMCACHE_SERVER', 	'127.0.0.1');
define('MEMCACHE_PORT',		'11211');
define('MEMCACHE_TTL', 		 600 /*seconds*/);

function smarty_function_latestRSS($params, &$smarty)
{

	$feed_latest = NULL;

	if (extension_loaded('memcache')){

		$memcache = new Memcache();
		if($memcache->connect(MEMCACHE_SERVER, MEMCACHE_PORT)){

			if (!($feed_latest = $memcache->get('latest_feed_content'))){
				$feed_latest = _latestRSS_getMostRecentFeedItem();
				$memcache->set('latest_feed_content', $feed_latest, 0, MEMCACHE_TTL);
			}

		} else
			return '<h2>Sad Face...</h2><p>Couldn\'t open a connection to memcache</p>';

	}//if extension_loaded

	if ($feed_latest === NULL)
		$feed_latest = _latestRSS_getMostRecentFeedItem();

	if ($feed_latest === NULL)
		$feed_latest = '';

	return $feed_latest;

}

function _latestRSS_getMostRecentFeedItem(){

	require_once('createfeed.inc.php');
	$feed = getFeedContent();
	$feed = str_replace(array('<![CDATA[', ']]>'), '', $feed);
	$xml = new SimpleXMLElement($feed);

	$items = $xml->xpath('/rss/channel/item');
	$title = !empty($items[0]->title) ? htmlspecialchars((string)$items[0]->title) : '';
	$description = !empty($items[0]->description) ? htmlspecialchars((string)$items[0]->description) : '';
	$link = !empty($items[0]->link) ? htmlspecialchars((string)$items[0]->link) : '';

	return "<h2>$title</h2><p>$description <a href=\"$link\">Read More...</a></p>";

}

?>





