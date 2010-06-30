#!/bin/bash

clear

APACHE_USER=$(ps --pid $(pgrep httpd | tail -n 1) -o user | tail -n 1)
if [ ! "$APACHE_USER" == "" ]
then
	APACHE_USER="apache"
fi

echo "Adding write permissions for '$APACHE_USER' in the following directories:"

echo "  - 'templates_compiled'"
setfacl -m u:$APACHE_USER:rwx templates_compiled/

echo "  - 'cache'"
setfacl -m u:$APACHE_USER:rwx cache/

if [[ $EDITOR == "" ]]
then
	EDITOR=vi
fi

echo ""
echo -e "Have you checked the settings in 'config.inc.php'? [Y/n]: \c"
read input

if [[ $input == "n" ]]
then
	echo ""
	echo "You should!"
	echo "The most important thing is the ROOT_URI setting."
	echo "Perhaps, one day, this script will do that for you."
	echo ""

	echo -e "\nEdit in $EDITOR now? [Y/n]: \c"
	read input2

	if [[ ! $input2 == "n" ]]
	then
		$EDITOR config.inc.php
	fi
else
	echo "Well done!"
fi


echo ""
echo -e "Have you checked the the '.htaccess' file? [Y/n]: \c"
read input

if [[ $input == "n" ]]
then

	echo ""
	echo "You should!"
	echo "The thing that'll need changing is mod_rewrite's 'RewriteBase'."
	echo ""

	echo -e "\nEdit in $EDITOR now? [Y/n]: \c"
	read input2

	if [[ ! $input2 == "n" ]]
	then
		$EDITOR .htaccess
	fi

else
	echo "Well done!"
fi

exit 0
