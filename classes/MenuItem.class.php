<?php

/*
 * A class to represent a node in a menu hierachy. One MenuItem
 * instance has an array (which can be empty) of MenuItems below
 * it in the hierachy -- i.e. representing the tree.
 */
class MenuItem {

	/*
	 * Constructor. Stores passed arguments, and initialises
	 * the subMenuItems array.
	 */
	function __construct($name, $text, $link, $subMenuItems = NULL){

		$this->text = $text;
		$this->link = $link;
		$this->name = $name;

		$this->subMenuItems = Array();
		if ($subMenuItems != NULL)
			$this->subMenuItems = $subMenuItems;

	}//__construct



	/*
	 * Returns a string representing the menu hierachy at and
	 * below the current item. The hierachy is produced 
	 * recursively, with MenuItems represented with ULs in 
	 * the LIs of ULs.
	 */
	function getItemHTML(){

		$output = "<li><a href='$this->link'>$this->text</a>";
		if ($this->subMenuItems != NULL){
			
			$output .= "\n<ul>\n";

			foreach ($this->subMenuItems as $item){
				$output .= $item->getItemHTML();
			}

			$output .= "</ul>\n";
		}

		$output .= "</li>\n";

		return $output;

	}//getItemHTML



	/*
	 * Adds an item, $item, to the array. 
	 */
	function addSubMenuItem($item){

		$this->subMenuItems[] = $item;

	}//addSubMenuItem



	/*
	 * Try to find an item in $this->subMenuItems and if 
	 * it exists, return the item. 
	 */
	function getSubMenuItemByName($name){

		foreach($this->subMenuItems as $item)
			if ($item->name == $name)
				return $item;

		return NULL;
	
	}//getSubMenuItemByName

}//class

?>
