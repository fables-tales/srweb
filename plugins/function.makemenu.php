<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.makemenu.php
 * Type:     function
 * Name:     makemenu
 * Purpose:  outputs a random magic answer
 * -------------------------------------------------------------
 */
function smarty_function_makemenu($params, &$smarty)
{
    return $params['menu']->getMenuHtml();
}
?> 
