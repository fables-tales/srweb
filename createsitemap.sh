#!/bin/bash

ROOT_URI="https://www.studentrobotics.org/"

echo '<?xml version="1.0" encoding="UTF-8"?>' > sitemap.xml
echo "<urlset\
 xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"\
 xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\
 xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9\
  http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">" >> sitemap.xml

URLS=$( find content/default/ |
	grep --invert-match -E '\..*$' |
	grep --invert-match -E '\/index$' |
	awk '{ sub(/^content\/default\//, ""); print }' |
	xargs -I {} echo {}
)

for i in $URLS; do

	if [ -d "content/default/$i" ]; then
		echo "$i/"
	else
		echo $i
	fi

done | xargs -I {} echo -e "\n\t<url>\n\t\t<loc>$ROOT_URI{}</loc>\n\t</url>" >> sitemap.xml

echo '</urlset>' >> sitemap.xml

exit 0
