<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.newsPage.php
 * Type:     function
 * Name:     newsPage
 * Purpose:  Paginates the news feed
 * -------------------------------------------------------------
 */
require_once('config.inc.php');
define('MEMCACHE_TTL',		600 /*seconds*/);

function smarty_function_newsPage($params, &$smarty)
{

	require_once('createfeed.inc.php');
	$feed = getFeedContent();
	$feed = str_replace(array('<![CDATA[', ']]>'), '', $feed);

	$xml = new SimpleXMLElement($feed);
	$items = $xml->xpath('/rss/channel/item');

	foreach ($items as $item){

		$title = !empty($item->title) ? htmlspecialchars((string)$item->title) : '';
		$description = !empty($item->description) ? htmlspecialchars((string)$item->description) : '';
		$link = !empty($item->link) ? htmlspecialchars((string)$item->link) : '';

		$output .= "<h2><a href='$link'>$title</a></h2><p>$description <a href=\"$link\">Read More...</a></p>";

	}//foreach

	return $output;
}


?>
