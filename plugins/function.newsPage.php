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
define('ITEMS_PER_PAGE', 1);

function smarty_function_newsPage($params, &$smarty)
{

	require_once('createfeed.inc.php');
	require_once('classes/Content.class.php');
	$feed = getFeedContent();
	$feed = str_replace(array('<![CDATA[', ']]>'), '', $feed);

	$xml = new SimpleXMLElement($feed);
	$items = $xml->xpath('/rss/channel/item');

	foreach ($items as $item){

		$title = !empty($item->title) ? htmlspecialchars((string)$item->title) : '';
		$description = !empty($item->description) ? htmlspecialchars((string)$item->description) : '';
		$link = !empty($item->link) ? htmlspecialchars((string)$item->link) : '';

		$content = new Content('content/default/' . str_replace($smarty->get_template_vars('base_uri'), '', $link));
		$contentHTML = str_replace(
			array('<h3', '<h2', '<h1', '</h3', '</h2', '</h1'),
			array('<h4', '<h3', '<h2', '</h4', '</h3', '</h2'),
			$content->getParsedContent()
		);

		$output .= $contentHTML;

		$output .= '<span class="newsInfo">Published: ' . date('jS M, H:i', strtotime($content->getMeta('PUB_DATE'))) . 
			' | <a href="' . $link . '">permalink</a> | <a href="' . 
			'content/default/' . str_replace($smarty->get_template_vars('base_uri'), '', $link) . '">original</a></span><p>&nbsp;</p>';

	}//foreach

	return $output;
}


?>
