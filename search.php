<?php

if (!empty($_GET['q'])){

	$q = htmlspecialchars($_GET['q']);
	header("Location: http://www.google.com/search?q=" . $q . "&sitesearch=www.studentrobotics.org");

} else {

	header("Location: " . $_SERVER['HTTP_REFERER']);

}
?>
