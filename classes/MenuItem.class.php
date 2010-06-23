<?php

class MenuItem {

	function __construct($text, $link, $subMenuItems = NULL){

		$this->text = $text;
		$this->link = $link;
		$this->subMenuItems = $subMenuItems;

	}//__construct

	function getItemHtml(){

		$output = "<li><a href='$this->link'>$this->text</a>";
		if ($this->subMenuItems != NULL){
			
			$output .= "<ul>";

			foreach ($this->subMenuItems as $item){
				$output .= $item->getItemHtml();
			}

			$output .= "</ul>";
		}

		$output .= "</li>";

		return $output;

	}//getItemHtml



	function addSubMenuItem($item){

		$this->subMenuItems[] = $item;

	}//addSubMenuItem

}//class

?>
