<?php

class Menu {

	function addMenuItem($menuItem){
		
		$this->menuItems[] = $menuItem;

	}//addMenuHtml



	function getMenuHtml(){

		$output = "<ul>";

		foreach ($this->menuItems as $item){

			$output .= $item->getItemHtml();

		}//foreach

		$output .= "</ul>";

		return $output;
		
	}//getMenuHtml

}//class


?>
