<?php
/*
 * A class to represent a complete menu. It is dependent upon
 * MenuItem.class.php as this instantiated class's root is a
 * MenuItem. This class is used by the smarty plugin 'makemenu',
 * found under 'plugins/' as 'function.makemenu.php', which
 * calls its 'getMenuHTML()' method to get the menu.
 */
class Menu {

	/*
	 * Constructor. Instantiates the root MenuItem.
	 */
	function __construct(){

		$this->root = new MenuItem(NULL, NULL, NULL);

	}//__construct



	/*
	 * Returns a string containing the un-ordered list of the menu.
	 * Ensure menu is populated first (addToHierachy(...)).
	 */
	function getMenuHTML(){

		$output = "<ul>\n";

		//starting with the root, traverse the tree, concatenating the output.
		foreach ($this->root->subMenuItems as $item){

			$output .= $item->getItemHTML($this->root_uri);

		}//foreach

		$output .= "</ul>\n";

		return $output;
		
	}//getMenuHTML



	/*
	 * Adds a path (such as 'dir/file') to the hierachy. $path is
	 * the path to the file, relative to the content dir, and
	 * excluding any extension. $root_uri is the URI that would be
	 * used to access the directory containing index.php. $text is
	 * is the text you wish to be displayed on the page.
	 */
	function addToHierachy($path, $root_uri, $text=""){

		//get all parts of the path (e.g. 'dir/dir2/file' => array(dir, dir2, file))
		preg_match_all( '/([a-zA-Z0-9\-\.]+)\/?/', $path, $matches);
		$matches = $matches[1];

		//start at the root
		$previous_item = $this->root;

		$path_tmp = $root_uri;

		foreach($matches as $name){

			//if the menuitem doesn't exist, add it
			if ($previous_item->getSubMenuItemByName($name) == NULL){
				if ($text != "" && $name == end($matches))
					$previous_item->addSubMenuItem(new MenuItem($name, $text, $path_tmp.$name));
				else
					$previous_item->addSubMenuItem(new MenuItem($name, $name, $path_tmp.$name));

			}

			//append the current part of the path to the previous, and update $previous_item
			$path_tmp .= $name . '/';
			$previous_item = $previous_item->getSubMenuItemByName($name);

		}//foreach

	}//addToHierachy

}//class


?>
