<?php
namespace Novaxis\Plugins\AutomatedTranslation\FT\ToYAML;
use Symfony\Component\Yaml\Yaml;
use Novaxis\Plugins\AutomatedTranslation\FT\ToJSON\Translator as FTJSONTranslator;

class Translator {
	/**
	 * @var FTJSONTranslator The FTJSONTranslator instance for translating data to JSON format.
	 */
	private FTJSONTranslator $FTJSONTranslator;

	/**
     * @var Yaml The Yaml instance for handling YAML operations.
     */
	private YAML $YAML;

	/**
     * Translator constructor.
	 * 
     * Initializes the FTJSONTranslator and Yaml instances.
     */
	public function __construct() {
		$this -> FTJSONTranslator = new FTJSONTranslator;
		$this -> YAML = new Yaml;
	}

	/**
	 * Translate Function
	 *
	 * Translates data from the source format to YAML format.
	 *
	 * @param array $source The source data to be translated.
	 * @return string The translated data in YAML format.
	 */
	public function Translate($source = array()) {
		$JSONData = $this -> FTJSONTranslator -> Translate($source);
		$YAMLData = $this -> YAML -> dump($JSONData);
		return $YAMLData;
	}
	
	/**
     * OutToFile Function
     *
     * Writes the translated data to a file in YAML format.
     *
     * @param string $filename The name of the file to write to.
     * @param array $source The source data to be written.
     * @return bool True if the write operation is successful, false otherwise.
     */
	public function OutToFile($filename, $source = array()): bool {
		$string = $this -> Translate($source);
		if (file_put_contents($filename, $string) !== false) {
			return true;
		}
		return false;
	}
}