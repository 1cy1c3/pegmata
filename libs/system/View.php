<?php
/**
 * This template engine is responsible for the 
 * presentation of all data.
 *
 * @author Rune Krauss
 *
 */
class View {
	/**
	 * Directory of the templates.
	 *
	 * @access private
	 * @var String
	 */
	private $templateDir;
	
	/**
	 * Directory of the language files.
	 *
	 * @access private
	 * @var String
	 */
	private $languageDir;
	
	/**
	 * Left delimiter for a default placeholder.
	 *
	 * @access private
	 * @var String
	 */
	private $leftDelimiter = '{$';
	
	/**
	 * Right delimiter for a default placeholder.
	 *
	 * @access private
	 * @var String
	 */
	private $rightDelimiter = '}';
	
	/**
	 * Left delimiter for a function.
	 *
	 * @access private
	 * @var String
	 */
	private $leftDelimiterF = '{';
	
	/**
	 * Right delimiter for a function.
	 *
	 * @access private
	 * @var String
	 */
	private $rightDelimiterF = '}';
	
	/**
	 * Left delimiter for a comment.
	 *
	 * @access private
	 * @var String
	 */
	private $leftDelimiterC = '\{\*';
	
	/**
	 * Right delimiter for a comment.
	 *
	 * @access private
	 * @var String
	 */
	private $rightDelimiterC = '\*\}';
	
	/**
	 * Left delimiter for a language variable.
	 *
	 * @access private
	 * @var String
	 */
	private $leftDelimiterL = '\{L_';
	
	/**
	 * Right delimiter for a language variable.
	 *
	 * @access private
	 * @var String
	 */
	private $rightDelimiterL = '\}';
	
	/**
	 * Full path to the template file.
	 *
	 * @access private
	 * @var String
	 */
	private $templateFile = '';
	
	/**
	 * Full path to the language file.
	 *
	 * @access private
	 * @var String
	 */
	private $languageFile = '';
	
	/**
	 * File name of the template.
	 *
	 * @access private
	 * @var String
	 */
	private $templateName = "";
	
	/**
	 * Content of the template.
	 *
	 * @access private
	 * @var String
	 */
	private $template = "";
	
	/**
	 * Sets the paths.
	 *
	 * @access public
	 */
	public function __construct($tpl_dir, $lang_dir) {
		// Template directory
		if (! empty ( $tpl_dir )) {
			$this->templateDir = $tpl_dir;
		}
		
		// Language directory
		if (! empty ( $lang_dir )) {
			$this->languageDir = $lang_dir;
		}
	}
	
	/**
	 * Opens the specific template file.
	 *
	 * @access public
	 * @param String $file
	 *        	File name of the template.
	 *        	
	 * @return boolean Status
	 */
	public function load($file) {
		// Assigns attributes
		$this->templateName = $file;
		$this->templateFile = $this->templateDir . $file;
		
		// Try to open the specific file
		if (! empty ( $this->templateFile )) {
			if (file_exists ( $this->templateFile )) {
				$this->template = file_get_contents ( $this->templateFile );
			} else {
				Logger::getInstance ()->log ( 'ERROR', 'The template ' . $this->templateFile . ' does not exist.' );
				throw new Exception ( 'The template ' . $this->templateFile . ' does not exist.' );
			}
		} else {
			return false;
		}
		
		// Parse functions
		$this->parseFunctions ();
	}
	
	/**
	 * Replaces a default placeholder.
	 *
	 * @access public
	 * @param String $replace
	 *        	Name of the placeholder
	 * @param string $replacement
	 *        	Text
	 */
	public function assign($replace, $replacement) {
		$this->template = str_replace ( $this->leftDelimiter . $replace . $this->rightDelimiter, $replacement, $this->template );
	}
	
	/**
	 * Opens the language files and replaces the language variables.
	 *
	 * @access public
	 * @param Array $files
	 *        	Name of the language files
	 * @uses $languageFiles
	 * @uses $languageDir
	 * @uses replaceLangVars()
	 * @return Array Language
	 */
	public function loadLanguage($files) {
		$this->languageFiles = $files;
		
		$lang = array ();
		
		// Try to load all language files
		for($i = 0; $i < count ( $this->languageFiles ); $i ++) {
			if (! file_exists ( $this->languageDir . $this->languageFiles [$i] )) {
				Logger::getInstance ()->log ( 'ERROR', 'The language file ' . $this->languageDir . $this->languageFiles [$i] . ' does not exist.' );
				throw new Exception ( 'The language file ' . $this->languageDir . $this->languageFiles [$i] . ' does not exist.' );
			} else {
				include_once ($this->languageDir . $this->languageFiles [$i]);
			}
		}
		
		// Replaces the language variables
		$this->replaceLangVars ( $lang );
		
		return $lang;
	}
	
	/**
	 * Replaces the language variables in the template.
	 *
	 * @access private
	 * @param String $lang
	 *        	Language variables
	 * @uses $template
	 */
	private function replaceLangVars($lang) {
		$this->template = preg_replace_callback ( "/\{L_(.*)\}/isU", function ($matches) use ($lang) {
			return $lang [strtolower ( $matches [1] )];
		}, $this->template );
	}
	
	/**
	 * Parses included files and removes the comments.
	 *
	 * @access private
	 * @uses $leftDelimiterF
	 * @uses $rightDelimiterF
	 * @uses $template
	 * @uses $leftDelimiterC
	 * @uses $rightDelimiterC
	 */
	private function parseFunctions() {
		// Includes ersetzen ( {include file="..."} )
		while ( preg_match ( "/" . $this->leftDelimiterF . "include file=\"(.*)\.(.*)\"" . $this->rightDelimiterF . "/isUe", $this->template ) ) {
			$this->template = preg_replace ( "/" . $this->leftDelimiterF . "include file=\"(.*)\.(.*)\"" . $this->rightDelimiterF . "/isUe", "file_get_contents(\$this->templateDir.'\\1'.'.'.'\\2')", $this->template );
		}
		
		// Kommentare löschen
		$this->template = preg_replace_callback ( "/" . $this->leftDelimiterC . "(.*)" . $this->rightDelimiterC . "/isU", function ($matches) {
			return "";
		}, $this->template );
	}
	
	/**
	 * Shows the finished template.
	 *
	 * @access public
	 * @uses $template
	 */
	public function render() {
		echo $this->template;
	}
	/**
	 * Loads the view.
	 *
	 * @return String Template
	 */
	public function loadView() {
		return $this->template;
	}
	
	/**
	 * Parses the database loops.
	 *
	 * @access public
	 * @param String $loopname
	 *        	Name of the loop
	 * @param String $dbdata
	 *        	The array which is created
	 * @uses $leftDelimiterF
	 * @uses $rightDelimiterF
	 * @uses $template
	 */
	public function iterate($loopname, $dbdata) {
		// Start and end tag for loop
		$start_tag = $this->leftDelimiterF . 'loop name="' . $loopname . '"' . $this->rightDelimiterF;
		$end_tag = $this->leftDelimiterF . '/loop name="' . $loopname . '"' . $this->rightDelimiterF;
		
		for($z = 0; (strpos ( $this->template, $start_tag ) + strlen ( $start_tag ) != strlen ( $start_tag )); $z ++) {
			// Get position of start and end tag
			$pos1 = strpos ( $this->template, $start_tag ) + strlen ( $start_tag );
			$pos2 = strpos ( $this->template, $end_tag, $pos1 );
			
			// Get the loop code between start and end tag
			$loopcode = substr ( $this->template, $pos1, $pos2 - $pos1 );
			
			// Replace the loop code
			$loopcontent = "";
			for($i = 0; $i < count ( $dbdata ); $i ++) {
				$loopcontent .= preg_replace_callback ( "/\{\\$(.*)\[" . $loopname . "\]\}/isU", function ($matches) use ($dbdata, $i) {
					return $dbdata [$i] [$matches [1]];
				}, $loopcode );
			}
			
			$this->template = substr ( $this->template, 0, $pos1 - strlen ( $start_tag ) ) . $loopcontent . substr ( $this->template, $pos2 + strlen ( $end_tag ) );
		}
	}
}