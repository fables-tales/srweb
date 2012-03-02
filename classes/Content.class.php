<?php

class Content {

	private $desiredFields = array(
		'TITLE',
		'DESCRIPTION',
		'KEYWORDS',
		'CONTENT_TYPE',
		'REDIRECT',
		'PUB_DATE'
	);

	public $filename = '';
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

		$this->filename = $filename;

		//open and read file
		$fh = fopen($filename, 'r') or die("Can't open file: $filename");

		$firstLine = TRUE;

		while (!feof($fh)){

			$line = fgets($fh);//read line

			// Some things only happen on the first line, so special case
			if ($firstLine){
				$firstLine = FALSE;
				// BOM search: UTF-8 *only*
				$bom = "\xef\xbb\xbf";	// strlen = 3

				if ($bom == substr($line, 0, 3)){
					$line = substr($line, 3);
				}
			}

			if (self::isComment($line)){

				$this->getField($line);
				continue; //get next line

			}//if

			//if we've gotten this far, then there's been a gap in the
			//commented header section -- assuming actual content now.
			//store content
			$this->content = stream_get_contents($fh);

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
	 * Replaces both 'href' and 'src' absolute links of the form
	 * '/some/page' with 'ROOT_URI/some/page'
	 */
	private static function fixAbsoluteLinks($content) {
		return preg_replace('/(href|src)="\/([^\"]*)"/', '$1="'.ROOT_URI.'$2"', $content);
	}

	/*
	 * Returns a string containing the metadata field, $field.
	 */
	function getMeta($field){

		if (isset($this->meta[$field]))
			return htmlspecialchars($this->meta[$field]);
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

			//uppercase content type. If content type not specified, default to markdown.
			//(quick way to stop PHP errors when empty place-holding files are used.)
			$upper_content = isset($this->meta['CONTENT_TYPE']) ? strtoupper($this->meta['CONTENT_TYPE']) : 'MARKDOWN';

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

		return self::fixAbsoluteLinks($this->parsedContent);

	}//getContent



	/*
	 * Returns the date specified in the file
	 */
	function getPubDate(){

		if ($this->getMeta('PUB_DATE') === ""){
			$f = fopen($this->filename, 'w');
			$date = date(DATE_RSS);

			foreach (array_keys($this->meta) as $k){
				$s = "//$k: " . $this->meta[$k] . "\n";
				fwrite($f, $s);
			}

			fwrite($f, "//PUB_DATE: " . $date . "\n");

			fwrite($f, "\n" . $this->content);
			fclose($f);
			return $date;
		}

		return $this->getMeta('PUB_DATE');

	}//getPubDate


}//class

function _parser_markdown($rawData)
{
	require_once('markdown.php');
	return Markdown($rawData);
}

function _parser_php($rawData)
{
	ob_start();
	eval(' ?>' . $rawData . '<?php ');
	$retval = ob_get_contents();
	ob_end_clean();
	return $retval;
}

Content::registerParser('MARKDOWN', '_parser_markdown');
Content::registerParser('MD', '_parser_markdown');
Content::registerParser('PHP', '_parser_php');

?>
