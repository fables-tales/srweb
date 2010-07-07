<?php

/*
 * Returns the content of the feed to be served. This function is
 * used both with and without caching functionality (see above).
 */
function getFeedContent(){

	require_once('config.inc.php');
	require_once('classes/Content.class.php');

	$BASE_URL = !empty($_SERVER['HTTPS'])
		? 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/'
		: 'http://'  . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/';

	$newsItems = array();

	if ($d = opendir(CONTENT_DIR . '/news')){

		//get the files
		while (false !== ($file = readdir($d)))
			if (substr($file, 0, 1) != ".")//ignore {., .., .gitignore, etc...}
				$newsItems[] = new Content(CONTENT_DIR . '/news/' . $file);

		closedir($d);

		//build output based on the Content objects
		if (count($newsItems) > 0){

			$output  = "<?xml version='1.0'?><rss version='2.0'><channel>";
			$output .= "<title>Student Robotics Latest News</title>";
			$output .= "<link>" . $BASE_URL . "news/</link>";
			$output .= "<lastBuildDate>" . date(DATE_RSS) . "</lastBuildDate>";
			$output .= "<description>All the latest news from Student Robotics</description>";

			usort($newsItems, "dateStrCmp");

			foreach ($newsItems as $newsItem){

				$output .= "<item>";

				$output .= "<title><![CDATA[" . $newsItem->getMeta('TITLE') . "]]></title>";
				$output .= "<link>" . $BASE_URL . str_replace(CONTENT_DIR . '/', '', $newsItem->filename) . "</link>";
				$output .= "<guid>" . $BASE_URL . str_replace(CONTENT_DIR . '/', '', $newsItem->filename) . "</guid>";
				$output .= "<description><![CDATA[" . $newsItem->getMeta('DESCRIPTION') . "]]></description>";
				$output .= "<pubDate>" . date(DATE_RSS, strtotime($newsItem->getPubDate())) . "</pubDate>";

				$output .= "</item>";

			}//foreach

			$output .= "</channel></rss>";

			return $output;

		}

	}

	//return NULL if no success
	return NULL;

}//getFeedContent



function dateStrCmp($a, $b){

        if (strtotime($a->getPubDate()) == strtotime($b->getPubDate()))
                return 0;

        return strtotime($a->getPubDate()) > strtotime($b->getPubDate()) ? -1 : 1;

}//dateStrCmp



?>
