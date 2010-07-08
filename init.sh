#!/bin/bash

echo "Checking for Apache..."
pgrep httpd > /dev/null
if [ "$?" != "0" ]
then
	echo "Apache not running, trying to start..."
	which apachectl > /dev/null
	if [ "$?" != "0" ]
	then
		echo "ERROR: Apache(ctl) does not appear to be installed."
		exit 1;
	fi

	sudo apachectl start
	if [ "$?" != "0" ]
	then
		echo "ERROR: Couldn't start Apache"
		exit 1;
	fi
	echo "Apache started"
fi

echo "Checking for Memcached..."
pgrep memcached > /dev/null
if [ "$?" != "0" ]
then
	echo "Memcached not running, trying to start..."
	which memcached > /dev/null
	if [ "$?" != "0" ]
	then
		echo "ERROR: Memcache(d) not installed."
		exit 1;
	fi

	touch /tmp/memcached
	memcached -d -s /tmp/memcached -L
	sudo chmod 777 /tmp/memcached

	if [ "$?" != "0" ]
	then
		echo "ERROR: Couldn't start Memcached."
		exit 1;
	fi	

	echo "Memcache started."

fi
