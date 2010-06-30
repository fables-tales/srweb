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

	$c = $smarty->get_template_vars("content");
	if (strtoupper($params['get']) == "CONTENT"){

		return $c->getParsedContent();

	} else {

		return $c->getMeta(strtoupper($params['get']));

	}

	return '';
}
?> 
