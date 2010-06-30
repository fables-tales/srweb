<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.getFromContent.php
 * Type:     function
 * Name:     getFromContent
 * Purpose:  Allows access to a Content object
 * -------------------------------------------------------------
 */
function smarty_function_getFromContent($params, &$smarty)
{

	//grab Content object (assigned to smarty)
	$c = $smarty->get_template_vars("content");

	//if the request is for CONTENT, get the parsed content
	if (strtoupper($params['get']) == "CONTENT"){

		return $c->getParsedContent();

	//if it's not, assume it's a metadata field from the content file. 
	} else {

		return $c->getMeta(strtoupper($params['get']));

	}

	return '';
}
?> 
