<?php
namespace Novaxis\Core;

use Novaxis\Core\Tabs;
use Novaxis\Core\Syntax\Handler\ClassHandler;
use Novaxis\Core\Syntax\Handler\CommentHandler;
use Novaxis\Core\Syntax\Handler\DatatypeHandler;
use Novaxis\Core\Syntax\Handler\VariableHandler;
use Novaxis\Core\Syntax\Datatype\InheritanceType;
use Novaxis\Core\Syntax\Handler\Variable\Interpolation;

/**
 * Executes Novaxis code by handling syntax, data types, path, and inheritance for items, and others.
 *
 * @package Novaxis\Core
 */
class Executer {
	/**
     * @var Tabs The Tabs instance for handling indentation levels.
     */
	private Tabs $Tabs;

	/**
     * @var Path The Path instance for managing the path and inheritance of items.
     */
	private Path $Path;

	/**
     * @var ClassHandler The ClassHandler instance for handling class-related syntax.
     */
	private ClassHandler $ClassHandler;

	/**
     * @var DatatypeHandler The DatatypeHandler instance for managing data types.
     */
	private DatatypeHandler $DatatypeHandler;

	/**
     * @var VariableHandler The VariableHandler instance for handling variable syntax.
     */
	private VariableHandler $VariableHandler;

	/**
     * @var InheritanceType The InheritanceType instance for managing inheritance.
     */
	private InheritanceType $InheritanceType;

	/**
     * @var Interpolation The Interpolation instance for handling variable interpolation.
     */
	private Interpolation $Interpolation;
	
	/**
     * @var CommentHandler The CommentHandler instance for handling comments in the code.
     */
	private CommentHandler $CommentHandler;

	/**
	 * Constructor for the Executer class.
	 *
	 * @param Path $Path An instance of the Path class used for managing the path and navigating the nested structure of items.
	 */
	public function __construct(Path $Path) {
		$this -> Tabs = new Tabs;
		$this -> Path = $Path;
		$this -> ClassHandler = new ClassHandler;
		$this -> CommentHandler = new CommentHandler;
		$this -> DatatypeHandler = new DatatypeHandler;
		$this -> VariableHandler = new VariableHandler;
		$this -> InheritanceType = new InheritanceType;
		$this -> Interpolation = new Interpolation;
	}

	/**
	 * The parameter function is responsible for processing and handling the parameter line in Novaxis code.
	 *
	 * @param string|null $previousLine The previous line of code.
	 * @param string|null $currentLine The current line of code.
	 * @param string|null $nextLine The next line of code.
	 * @param bool $firstline A boolean flag indicating if it's the first line of the code.
	 * @return array|null An array containing the items created from the processed lines.
	 */
	public function parameter(?string $previousLine, ?string $currentLine, ?string $nextLine, $firstline = false) {
		if (!trim($currentLine)) {
			return $this -> Path -> getItems();
		}

		if ($this -> CommentHandler -> is($currentLine)) {
			$currentLine = $this -> CommentHandler -> split($currentLine);
			
			if (!trim($currentLine)) {
				return $this -> Path -> getItems();
			}
		}

		$forwardClassName = null;
		$classDatatype = null;
		$tabHandling = $this -> Tabs -> handling($previousLine, $currentLine);
		
		if ($tabHandling == 'backward') {
			$this -> Path -> backward($this -> Tabs -> getDifferenceNumber($previousLine, $currentLine));
		}

		if ($this -> ClassHandler -> isClass($currentLine)) {
			if (($tabHandling == 'forward' || $firstline) && $this -> Tabs -> handling($currentLine, $nextLine) == 'forward') {
				$forwardClassName = $this -> ClassHandler -> getClassName($currentLine);
				$classDatatype = $this -> ClassHandler -> getClassDatatype($currentLine);
			} else if ($tabHandling == 'backward') {
				$this -> Path -> backward($this -> Tabs -> getDifferenceNumber($previousLine, $currentLine));
				
				if ($this -> Tabs -> handling($currentLine, $nextLine) == 'forward') {
					$forwardClassName = $this -> ClassHandler -> getClassName($currentLine);
					$classDatatype = $this -> ClassHandler -> getClassDatatype($currentLine);
				}

			} else if ($tabHandling == 'nothing' && $this -> Tabs -> handling($currentLine, $nextLine) == 'forward') {
				$forwardClassName = $this -> ClassHandler -> getClassName($currentLine);
				$classDatatype = $this -> ClassHandler -> getClassDatatype($currentLine);
			}
			
			if ($forwardClassName || $classDatatype) {
				$this -> Path -> forward(trim($forwardClassName));
				
				if ($classDatatype) {
					$this -> InheritanceType -> addItem($this -> Path -> getFullPath(), $classDatatype);
				}
			}
		}
		
		else if ($this -> VariableHandler -> isVariable($currentLine)) {
			$allVariableDetails = $this -> VariableHandler -> getAllVariableDetails($currentLine);
			
			if ($this -> CommentHandler -> is($allVariableDetails['value'])) {
				$allVariableDetails['value'] = $this -> CommentHandler -> split($allVariableDetails['value']);
			}

			if ($allVariableDetails['datatype'] === null) {
				$allVariableDetails['datatype'] = $this -> InheritanceType -> getItem($this -> Path -> getFullPath());
			}
			
			if ($this -> Interpolation -> hasInterpolation($allVariableDetails['value'])) {
				$allVariableDetails['value'] = $this -> Interpolation -> replaceValue($allVariableDetails['value'], $this -> Path -> getItems(), $this -> Path -> clean($this -> Path -> getFullPath()));
			}

			$allVariableDetails['datatype'] = $this -> DatatypeHandler -> datatypeInterpolation($allVariableDetails['datatype'], $this -> Path -> getItems(), $this -> Path -> getFullPath());
			$this -> DatatypeHandler -> createDatatype($allVariableDetails['datatype'], $allVariableDetails['value']);
			$allVariableDetails['value'] = $this -> DatatypeHandler -> getValue();
			
			if ($this -> DatatypeHandler -> getDatatype() === 'Auto') {
				$autoValues = $this -> DatatypeHandler -> getDatatypeConnection() -> getItem();
				
				$allVariableDetails['datatype'] = $autoValues['datatype'];
				$allVariableDetails['value'] = $autoValues['value'];
			}
			
			$this -> Path -> addItem($allVariableDetails['name'], ucfirst($allVariableDetails['datatype']), $allVariableDetails['value'], $allVariableDetails['visibility']);

			return $this -> Path -> getItems();
		}

		else if ($this -> ClassHandler -> isClassBox($currentLine)) {
			$classBox = $this -> ClassHandler -> getClassBox($currentLine);

			$this -> InheritanceType -> addItem($this -> Path -> getFullPath(), $classBox);
		}
	}
}