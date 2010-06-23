<?php

class MenuItem {

	function __construct($name, $text, $link, $subMenuItems = NULL){

		$this->text = $text;
		$this->link = $link;
		$this->name = $name;
		$this->subMenuItems = Array();
		if ($subMenuItems != NULL)
			$this->subMenuItems = $subMenuItems;

	}//__construct

	function getItemHtml(){

		$output = "<li><a href='$this->link'>$this->text</a>";
		if ($this->subMenuItems != NULL){
			
			$output .= "\n<ul>\n";

			foreach ($this->subMenuItems as $item){
				$output .= $item->getItemHtml();
			}

			$output .= "</ul>\n";
		}

		$output .= "</li>\n";

		return $output;

	}//getItemHtml



	function addSubMenuItem($item){

		$this->subMenuItems[] = $item;

	}//addSubMenuItem




	function getSubMenuItemByName($name){

		foreach($this->subMenuItems as $item)
			if ($item->name == $name)
				return $item;

		return NULL;
	
	}

}//class

?>
