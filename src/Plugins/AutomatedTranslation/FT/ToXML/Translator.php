<?php
namespace Novaxis\Plugins\AutomatedTranslation\FT\ATXML;
use Novaxis\Plugins\AutomatedTranslation\FT\ToJSON\Translator as FTJSONTranslator;

class Translator {
	private FTJSONTranslator $FTJSONTranslator;

	private function __construct() {
		$this -> FTJSONTranslator = new FTJSONTranslator;
	}

	private function Translate($source = array(), string $rootElement = 'root') {
		$JSONData = $this -> FTJSONTranslator -> Translate($source);

		$dom = new \DOMDocument('1.0', 'UTF-8');
		$dom -> preserveWhiteSpace = false;
		$dom -> formatOutput = true;

		$root = $dom -> createElement($rootElement);
		$dom -> appendChild($root);

		$this -> arrayToXml($dom, $root, $JSONData);

		return str_replace('  ', "\t", $dom -> saveXML());
	}

	private function arrayToXml(\DOMDocument $dom, \DOMElement $element, $JSONData) {
		foreach ($JSONData as $key => $value) {
			if (is_array($value)) {
				$child = $dom -> createElement($key);
				$element -> appendChild($child);
				$this -> arrayToXml($dom, $child, $value);
			}
			else {
				$element -> appendChild($dom -> createElement($key, $value));
			}
		}
	}

	private function OutToFile($filename, $source = array()): bool {
		$XMLData = $this -> Translate($source);
		if (file_put_contents($filename, $XMLData) !== false) {
			return true;
		}
		else {
			return false;
		}
	}
}