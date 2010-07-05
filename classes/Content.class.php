<?php

class Content {

	private $desiredFields = array(
		'TITLE',
		'DESCRIPTION',
		'KEYWORDS',
		'CONTENT_TYPE',
		'REDIRECT'
	);
	private $content = '';
	private $parsedContent = '';
	private $contentHasBeenParsed = false;
	private $meta = array();
	private static $parsers = array();

	public static function registerParser($type, $callback){
		self::$parsers[$type] = $callback;
	}

	/*
	 * Constructor. Takes a filename as an argument, grabs the meta 
	 * fields from it, and stores the remaining content (discarding 
	 * any additional comments before a line that does not start 
	 * with '//').
	 */
	function __construct($filename){

		//open and read file
		$fh = fopen($filename, 'r') or die("Can't open file: $filename");
		
		$end_of_comments = false;

		while (!feof($fh)){

			$line = fgets($fh);//read line

			if (self::isComment($line) && !$end_of_comments){

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
		$pattern = '/[[:space:]]*\/\/([^:]*):(.*)/';
		preg_match($pattern, $string, $matches);

		if ($matches){

			//get rid of leading & trailing whitespace
			$matches[1] = trim($matches[1]);
			$matches[2] = trim($matches[2]);

			//if we want the field, store it
			if (in_array($matches[1], $this->desiredFields))
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

		if (isset($this->meta[$field]))
			return $this->meta[$field];
		else
			return "";

	}//getMeta



	/*
	 * If the content is of a type that needs parsing, and if a method to
	 * parse it exists, then this method will return the parsed content. 
	 * If it doesn't need to/can't be parsed, the content will just be 
	 * returned as plain text. (This is no bad thing: HTML, for example 
	 * can just be returned as itself.)
	 */
	function getParsedContent(){

		if (!$this->contentHasBeenParsed){//it needs parsing

			//uppercase content type
			$upper_content = strtoupper($this->meta['CONTENT_TYPE']);

			//if it's a type that need parsing
			if (isset(self::$parsers[$upper_content])){

				$callback = self::$parsers[$upper_content];
				$this->parsedContent = $callback($this->content);
				$this->contentHasBeenParsed = true;

			} else {

				//content doesn't need parsing
				$this->parsedContent = $this->content;
				$this->contentHasBeenParsed = true;

			}//if-else

		}//if

		return $this->parsedContent;

	}//getContent


}//class

function _parser_markdown($rawData)
{
	require_once('markdown.php');
	return Markdown($rawData);
}

Content::registerParser('MARKDOWN', '_parser_markdown');
Content::registerParser('MD', '_parser_markdown');

?>
