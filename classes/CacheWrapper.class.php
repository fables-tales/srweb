<?php

/*
 * A wrapper class for general-purpose server-side caching. Using memcache(d).
 */
class CacheWrapper {

	public static $SERVER;
	public static $PORT;
	public static $PREFIX;
	public static $DEFAULT_TTL = 600; //10 mins
	public static $ENABLED;


	/*
	 * Sets the static class up. It can be used time and time again, without
	 * having to duplicate code, pass settings around, etc...
	 */
	public static function setup($server, $port, $main_prefix='', $default_ttl=-1, $enabled=true){

		self::$SERVER = $server;
		self::$PORT = $port;
		self::$PREFIX = $main_prefix;
		self::$ENABLED = $enabled;

		if ($default_ttl != -1)
			self::$DEFAULT_TTL = $default_ttl;

	}//setup


	/*
	 * Gets the item if it's in the cache, and returns it. If it's not, add
	 * it to the cache and return it. If caching isn't enabled/installed, it
	 * just returns the output of the passed function. The passed function is
	 * what's used to get the value to put in the cache.
	 */
	public static function getCacheItem($item_index, $ttl, $function){

		$var = NULL;

		if (self::$ENABLED && extension_loaded('memcache')){

			$memcache = new Memcache();

			if($memcache->pconnect(self::$SERVER, self::$PORT)){

				if (!($var = $memcache->get(self::$PREFIX . $item_index))){

					$var = $function();
					$actualTTL = $ttl == -1 ? self::$DEFAULT_TTL : $ttl;
					$memcache->set(self::$PREFIX . $item_index, $var, 0, $actualTTL);

				}

			}

		}//if enabled && loaded

		/*
		 * if something's not right, just return the return value of the
		 * function passed.
		 */
		if ($var == NULL)
			$var = $function();

		return $var;

	}//getCacheItem

}//class

require_once('config.inc.php');
CacheWrapper::setup(MEMCACHE_SERVER, MEMCACHE_PORT, '[' . ROOT_URI . ']', 600, MEMCACHE_ENABLED);

?>
