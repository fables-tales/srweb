<?php

class Content {

	/*
	 * Constructor. Takes a filename as an argument, grabs the meta 
	 * fields from it, and stores the remaining content (discarding 
	 * any additional comments before a line that does not start 
	 * with '//').
	 */
	function __construct($filename){

		$this->DESIRED_FIELDS = array(
			'TITLE',
			'DESCRIPTION',
			'KEYWORDS',
			'CONTENT_TYPE'
		);

		//add to this array to parse more types
		$this->CONTENT_TYPES = array(
			'MD', 'MARKDOWN'
		);

		$this->content = '';
		$this->parsedContent = '';
		$this->contentHasBeenParsed = false;

		$this->meta = array();	

		//open and read file
		$fh = fopen($filename, 'r') or die("Can't open file: $filename");
		
		$end_of_comments = false;

		while (!feof($fh)){

			$line = fgets($fh);//read line

			if ($this->isComment($line) && ! $end_of_comments){

				$this->getField($line);
				continue; //get next line

			}//if

			//if we've gotten this far, then there's been a gap in the
			//commented header section -- assuming actual content now.
			$end_of_comments = true;

			//store content
			$this->content .= $line;
			
		}//while

		fclose($fh);

	}//__construct



	/*
	 * Stores any metadata fields that are found at the top of the
	 * file in $this->meta array. It only stores fields that are
	 * "desired", therefore additional comments can be added to the
	 * header of a file with no problems.
	 */
	private function getField($string){

		$string = trim($string);
		$pattern = '/[[:space:]]*\/\/(.*):(.*)/';
		preg_match($pattern, $string, $matches);

		if ($matches){

			//get rid of leading & trailing whitespace
			$matches[1] = trim($matches[1]);
			$matches[2] = trim($matches[2]);

			//if we want the field, store it
			if (in_array($matches[1], $this->DESIRED_FIELDS))
				$this->meta[$matches[1]] = $matches[2];

			return true;

		}//if

		return false;

	}//getFields



	/*
	 * Returns true if $string is a comment line (i.e. the first 
	 * non-whitespace characters are '//') and false if not.
	 */
	private static function isComment($string){

		return 1 === preg_match('/^[[:space:]]*\/\//', $string);

	}//isComment



	/*
	 * Returns a string containing the metadata field, $field.
	 */
	function getMeta($field){

		return $this->meta[$field];

	}//getMeta



	/*
	 * If the content is of a type that needs parsing, and if a method to
	 * parse it exists, then this method will return the parsed content. 
	 * If it doesn't need to/can't be parsed, the content will just be 
	 * returned as plain text. (This is no bad thing: HTML, for example 
	 * can just be returned as itself.)
	 */
	function getParsedContent(){

		if (! $this->contentHasBeenParsed){//it needs parsing

			//uppercase content type
			$upper_content = strtoupper($this->meta['CONTENT_TYPE']);

			//if it's a type that need parsing
			if (in_array($upper_content, $this->CONTENT_TYPES)){

				//if a method to parse it exists (see below), call that method.
				if (method_exists($this, '_parse_' . $upper_content)){

					//call method of the form '_parse_{CONTENT_TYPE}' where 
					//'{CONTENT_TYPE}' is the upercase string of the type.
					call_user_func_array( array($this, '_parse_' . $upper_content), array());

				} else {

					//content can't be parsed
					$this->parsedContent = $this->content;
					$this->contentHasBeenParsed = true;

				}//if-else

			} else {

				//content doesn't need parsing
				$this->parsedContent = $this->content;
				$this->contentHasBeenParsed = true;

			}//if-else

		}//if

		return $this->parsedContent;

	}//getContent






	/*
	 * Parsing "plugins" take the following form:
	 * 
	 * 	private function _parse_{CONTENT_TYPE}(){...}
	 * 
	 * where '{CONTENT_TYPE}' is the type listed in $CONTENT_TYPES.
	 * They will be called automatically if the content type in
	 * question is loaded. No parameters are allowed.
	 */

	/*
	 * Parsing for MarkDown, using markdown.php from:
	 * http://michelf.com/projects/php-markdown/
	 */
	private function _parse_MD(){

		require_once('markdown.php');
		$this->parsedContent = Markdown($this->content);
		$this->contentHasBeenParsed = true;

	}//_parse_MD


	/*
	 * Uses the _parse_MD function to parse. This is just another
	 * way of using MarkDown. (i.e. users can write MD/md/MARKDOWN/
	 * markdown/{any mixed case variants}). 
	 */
	private function _parse_MARKDOWN(){

		$this->_parse_MD();

	}//_parse_MARKDOWN


}//class

?>
