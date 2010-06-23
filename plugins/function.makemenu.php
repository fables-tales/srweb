<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.makemenu.php
 * Type:     function
 * Name:     makemenu
 * Purpose:  Gets the output from a Menu object (and its 
 *           contained MenuItems)
 * -------------------------------------------------------------
 */
function smarty_function_makemenu($params, &$smarty)
{
    return $params['menu']->getMenuHtml();
}
?> 
