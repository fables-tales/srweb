<?php

require_once('config.inc.php');
require_once('classes/CacheWrapper.class.php');
require_once('createfeed.inc.php');
define('MEMCACHE_TTL',		300 /*seconds*/);


//do some caching stuff
$feed = CacheWrapper::getCacheItem('[feed_content]', MEMCACHE_TTL, function(){

	return getFeedContent(true);

});


if ($feed !== NULL){

	header("Content-Type: application/xml; charset=ISO-8859-1");
	echo $feed;

} else {

	header("HTTP/1.1 500 Internal Server Error");

}




?>
