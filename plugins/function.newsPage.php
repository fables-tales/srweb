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

	$p = $smarty->get_template_vars('p');

	for($i = ($p - 1) * ITEMS_PER_PAGE; $i < count($items) && $i < ($p - 1) * ITEMS_PER_PAGE + ITEMS_PER_PAGE; $i++){

		$item = $items[$i];

		$link = !empty($item->link) ? htmlspecialchars((string)$item->link) : '';

		$content = new Content('content/default/' . str_replace($smarty->get_template_vars('base_uri'), '', $link));
		$contentHTML = str_replace(
			array('<h3', '<h2', '<h1', '</h3', '</h2', '</h1'),
			array('<h4', '<h3', '<h2', '</h4', '</h3', '</h2'),
			$content->getParsedContent()
		);

		$timestamp = strtotime($content->getMeta('PUB_DATE'));

		$output .= '<div class="newsItem">';

		$output .= '<div class="newsDate">' .
				'<div class="day">' . date('d', $timestamp) . '</div>' .
				'<div class="month">' . date('M', $timestamp) . '</div>' .
				'<div class="year">' . date('Y', $timestamp) . '</div>' .
			   '</div>';

		$output .= '<div class="newsContent">' . $contentHTML . '</div>';

		$output .= '<div class="newsInfo">' .
			'<a href="' . $link . '">permalink</a> | ' .
				'<a href="content/default/' . str_replace($smarty->get_template_vars('base_uri'), '', $link) . '">original</a>' .
			'</div>';

		$output .= '</div>';

	}//foreach

	return $output;
}


?>
