<?php

if (!empty($_GET['q'])){

	$q = htmlspecialchars($_GET['q']);
	Header("Location: http://www.google.com/search?q=" . $q . "&sitesearch=www.studentrobotics.org");

} else {

	Header("Location: " . $_SERVER['HTTP_REFERER']);

}
?>
