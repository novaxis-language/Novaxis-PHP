<?php
namespace NOVAXIS\Core\Syntax\Datatype;

use NOVAXIS\Core\Path;
use NOVAXIS\Core\Syntax\Token\PathTokens;

/**
 * The InheritanceType class represents a data structure to handle inheritance paths and their associated datatypes.
 *
 * @package NOVAXIS\Core\Syntax\Datatype
 */
class InheritanceType {
	use PathTokens;

	/**
	 * Array to store the items with inheritance path and datatype mappings.
	 *
	 * @var array
	 */
	private array $items = [];

	/**
	 * Instance of the Path class to manage paths.
	 *
	 * @var Path
	 */
	private Path $Path;

	/**
	 * Constructor for the InheritanceType class.
	 */
	public function __construct() {
		$this -> Path = new Path;
	}
	
	/**
	 * Adds an item with an inheritance path and datatype to the collection.
	 *
	 * @param string $path The inheritance path.
	 * @param string $datatype The associated datatype.
	 * @return $this
	 */
	public function addItem(string $path, string $datatype) {
		$this -> items[$this -> Path -> clean($path)] = $datatype;

		return $this;
	}

	/**
	 * Retrieves the datatype associated with the given inheritance path.
	 *
	 * @param string $path The inheritance path.
	 * @return string|null The datatype associated with the path or null if not found.
	 */
	public function getItem(string $path) {
		$path = $this -> Path -> clean($path);
		$this -> Path -> setFullPath($path);

		foreach (range(0, substr_count($path, self::PATH_SEPARATOR)) as $rounds) {
			if (in_array($this -> Path -> getFullPath(), array_keys($this -> items)) ) {
				return $this -> items[$this -> Path -> getFullPath()];
			}

			$this -> Path -> backward();
		}

		return null;
	}

	/**
	 * Gets all items with inheritance path and datatype mappings.
	 *
	 * @return array The items with inheritance path and datatype mappings.
	 */
	public function getItems() {
		return $this -> items;
	}
}