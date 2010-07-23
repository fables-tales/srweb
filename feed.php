<?php

require_once('config.inc.php');
require_once('createfeed.inc.php');
define('MEMCACHE_TTL',		1800 /*seconds*/);

$feed = NULL;

if (MEMCACHE_ENABLED && extension_loaded('memcache')){

	$memcache = new Memcache();
	if($memcache->pconnect(MEMCACHE_SERVER, MEMCACHE_PORT)){

		if (!($feed = $memcache->get(MEMCACHE_PREFIX . 'feed_content'))){
			$feed = getFeedContent();
			$memcache->set(MEMCACHE_PREFIX . 'feed_content', $feed, 0, MEMCACHE_TTL);
		}

	}//if connect

}//if extension_loaded

if ($feed === NULL)
	$feed = getFeedContent();

if ($feed !== NULL){

	Header("Content-Type: application/xml; charset=ISO-8859-1");
	echo $feed;

} else {

	Header("HTTP/1.1 500 Internal Server Error");

}




?>
