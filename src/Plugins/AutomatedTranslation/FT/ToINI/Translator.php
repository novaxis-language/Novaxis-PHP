<?php
namespace Novaxis\Plugins\AutomatedTranslation\FT\ToINI;
use Laminas\Config\Config;
use Laminas\Config\Writer\Ini as IniWriter;
use Novaxis\Plugins\AutomatedTranslation\FT\ToJSON\Translator as FTJSONTranslator;

class Translator {
	/**
	 * @var FTJSONTranslator The FTJSONTranslator instance for translating data to JSON format.
	 */
	private FTJSONTranslator $FTJSONTranslator;

	/**
	 * @var IniWriter The IniWriter instance for writing data in INI format.
	 */
	private IniWriter $IniWriter;

	/**
	 * Translator constructor.
	 * 
	 * Initializes the FTJSONTranslator and IniWriter instances.
	 */
	public function __construct() {
		$this -> FTJSONTranslator = new FTJSONTranslator;
		$this -> IniWriter = new IniWriter();
	}

	/**
	 * Translate Function
	 *
	 * Translates data from the source format to INI format.
	 *
	 * @param array $source The source data to be translated.
	 * @return string The translated data in INI format.
	 */
	public function Translate($source = array()) {
		$JSONData = $this -> FTJSONTranslator -> Translate($source);
		
		$config = new Config($JSONData);

		return $this -> IniWriter -> toString($config);
	}
}