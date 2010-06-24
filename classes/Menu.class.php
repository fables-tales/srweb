<?php

class Menu {

	function __construct(){

		$this->root = new MenuItem(NULL, NULL, NULL);

	}


	function getMenuHtml(){

		$output = "<ul>\n";

		foreach ($this->root->subMenuItems as $item){

			$output .= $item->getItemHtml($this->root_uri);

		}//foreach

		$output .= "</ul>\n";

		return $output;
		
	}//getMenuHtml



	function addToHierachy($path, $root_uri){
		
		preg_match_all( '/([a-zA-Z0-9\-\.]+)\/?/' , $path, $matches);
		$matches = $matches[1];

		$previous_item = $this->root;

		$path_tmp = $root_uri;
		foreach($matches as $name){
			//echo($name.'__');
			if ($previous_item->getSubMenuItemByName($name) == NULL){
				$previous_item->addSubMenuItem(new MenuItem($name, $name, $path_tmp.$name));
			}
			$path_tmp .= $name . '/';
			$previous_item = $previous_item->getSubMenuItemByName($name);

		}//foreach

	}

}//class


?>
