<?php
namespace Novaxis\Core;

use Novaxis\Core\Path;
use Novaxis\Core\Executer;
use Novaxis\Core\File\Reader;
use Novaxis\Core\Error\Exception;
use Novaxis\Core\Syntax\Handler\Variable\VisibilitySyntax;

/**
 * The Runner class is responsible for executing the Novaxis code stored in a file.
 *
 * This class reads the Novaxis code from a file, processes it line by line, and executes
 * the commands based on the defined syntax. It uses the Executer and Path classes to
 * handle the parsing and execution of the Novaxis code.
 *
 * @package Novaxis\Core
 */
class Runner {
	/**
	 * The path to the Novaxis file to be executed.
	 *
	 * @var string
	 */
	private $filename;

	/**
	 * An instance of the Reader class for reading the Novaxis file.
	 *
	 * @var Reader
	 */
	private Reader $Reader;

	/**
	 * An instance of the Executer class for executing Novaxis code.
	 *
	 * @var Executer
	 */
	private Executer $Executer;

	/**
     * An instance of the VisibilitySyntax class to handle variable's visibility.
     *
     * @var VisibilitySyntax
     */
	private VisibilitySyntax $VisibilitySyntax;

	/**
	 * Runner constructor.
	 *
	 * @param string $filename The path to the Novaxis file to be executed.
	 */
	public function __construct($filename) {
		$this -> filename = $filename;
		$this -> Reader = new Reader($this -> filename);
		$this -> Executer = new Executer(new Path);
		$this -> VisibilitySyntax = new VisibilitySyntax;
	}

	/**
	 * Get the indentation level of a line in the Novaxis code.
	 *
	 * @param string $line The line of Novaxis code.
	 * @return int The number of leading tabs in the line.
	 */
	function getIndentationLevel($line) {
		return strspn($line, "\t");
	}
	
	/**
	 * Execute the Novaxis code stored in the file.
	 *
	 * @return array|null An array containing the items created from the processed lines, or null if an error occurred.
	 * @throws Exception When an exception occurs during code execution.
	 */
	public function execute() { // update the docblock
		$lines = $this -> Reader -> read_removed();
		
		$firstline = true;
		$previousLine = null;
		
		try {
			foreach ($lines as $lineNumber => $line) {
				if (empty($line)) {
					continue;
				}
	
				$nextLine = next($lines);
				
				$this -> Executer -> parameter($previousLine, $line, $nextLine, $firstline);
				$firstline = false;
		
				$previousLine = $line;
			}
			
			$value = $this -> Executer -> parameter($previousLine, end($lines), null, $firstline);	
			
			if (gettype($value) === 'NULL') {
				throw new Exception(null, 0);
			}

			return $this -> VisibilitySyntax -> remover($value);
		}
		
		catch (Exception $e){
			$e -> setLineNumber($lineNumber);
			echo $e . PHP_EOL;
		}

		catch (\TypeError $e) {
			throw new Exception(null, $lineNumber ?? 0);
		}
	}
}