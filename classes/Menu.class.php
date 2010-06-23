<?php

class Menu {

	function __construct(){

		$this->root = new MenuItem(NULL, NULL, NULL);
	
	}


	function getMenuHtml(){

		$output = "<ul>\n";

		foreach ($this->root->subMenuItems as $item){

			$output .= $item->getItemHtml();

		}//foreach

		$output .= "</ul>\n";

		return $output;
		
	}//getMenuHtml



	function addToHierachy($path){
		
		preg_match_all( '/([a-zA-Z0-9\-\.]+)\/?/' , $path, $matches);
		$matches = $matches[1];

		$previous_item = $this->root;

		$path_tmp = "";
		foreach($matches as $name){

			if ($previous_item->getSubMenuItemByName($name) == NULL){
				$path_tmp .= $name;
				$previous_item->addSubMenuItem(new MenuItem($name, $name, 'index.php?page='.$path_tmp));
			}
				
			$previous_item = $previous_item->getSubMenuItemByName($name);
			$path_tmp = $path_tmp.'/';

		}//foreach

	}

}//class


?>
