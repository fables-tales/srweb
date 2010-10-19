<?php

if (!empty($_GET['q'])){

	$q = htmlspecialchars($_GET['q']);
	header("Location: http://www.google.com/search?q=" . $q . "&sitesearch=www.studentrobotics.org");

} else {

	header("HTTP/1.1 400 Bad Request");
	header("Content-type: text/plain");

	echo "Please specify some search parameters.";

}
?>
