<?php
namespace Novaxis\Core\Syntax\Handler;

use Novaxis\Core\Syntax\Handler\Namingrules;

/**
 * The ClassHandler class handles operations related to class syntax and tokens.
 *
 * @package Novaxis\Core\Syntax\Handler
 */
class ClassHandler {
	/**
	 * Regular expression pattern for matching and parsing variable declarations.
	 *
	 * @var string
	 */
	private $pattern = '/^\s*([^=\s:->]+)\s*(?:\?\s*([^=:\n]*?(?:\([^)]*\))?(?:\s+[^=:\n]*?(?:\([^)]*\))?)*))?\s*(?:->\s*\d+)?\s*$/';

	/**
	 * Instance of the Namingrules class for validating naming rules.
	 *
	 * @var Namingrules
	 */
	private Namingrules $Namingrules;

	/**
	 * Constructor for the classHandler class.
	 */
	public function __construct() {
		$this -> Namingrules = new Namingrules;
	}

	/**
     * Checks if the given input represents a class declaration.
     *
     * @param string $input The input to check.
     * @return bool True if the input represents a class declaration, false otherwise.
     */
	function isClass($input) {
		$pattern = '/^\s*([^=\s:->]+)\s*(?:\?\s*([^=:\n]*?(?:\([^)]*\))?(?:\s+[^=:\n]*?(?:\([^)]*\))?)*))?\s*(?:->\s*\d+)?\s*$/';
	
		return preg_match($pattern, $input);
	}

	/**
	 * Check if the input string represents a class box with datatype.
	 *
	 * @param string $input The input string to check.
	 * @return bool True if the input is a valid class box with datatype, otherwise false.
	 */
	public function isClassBox($input) {
		$pattern = '/^\s*\?\s*((\w|\W){0,})\s*$/';
		
		return preg_match($pattern, $input);
	}
	
	/**
	 * Get the datatype from a class box representation.
	 *
	 * @param string $input The input string containing the class box representation.
	 * @return string|null The extracted datatype if found, or null if the format is invalid.
	 */
	public function getClassBox($input) {
		$pattern = '/^\s*\?\s*((\w|\W){0,})\s*$/';
		preg_match($pattern, $input, $matches);

		return trim($matches[1]);
	}

	/**
	 * Extracts the class name from the given input.
	 *
	 * @param string $input The input to extract the class name from.
	 * @return string|null The name of the class, or null if not found.
	 * @throws 'NamingRuleException' If the extracted class name is invalid according to naming rules.
	 */
	function getClassName($input) {
		if (preg_match($this -> pattern, $input, $matches)) {
			$this -> Namingrules -> isValid($matches[1], true);
			
			return $matches[1];
		}
	
		return null;
	}

	/**
     * Extracts the datatype of the class from the given input.
     *
     * @param string $input The input to extract the class datatype from.
     * @return string|null The datatype of the class, or null if not found.
     */
	function getClassDatatype($input) {
		if (preg_match($this -> pattern, $input, $matches)) {
			return $matches[2] ?? null;
		}

		return null;
	}

	/**
	 * Get the maximum number from the given syntax.
	 *
	 * @param string $syntax The syntax string to extract the maximum number from.
	 * @return string The extracted maximum number or an empty string if not found.
	 */
	function getMaximumNumber(string $syntax): string {
		$pattern = '/\s*->\s*(\d+)\s*$/';

		preg_match($pattern, $syntax, $matches);

		return isset($matches[1]) ? $matches[1] : '';
	}
}