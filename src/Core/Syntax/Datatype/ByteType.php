<?php
namespace Novaxis\Core\Syntax\Datatype;

use Novaxis\Core\Error\ConversionErrorException;
use Novaxis\Core\Syntax\Datatype\TypesInterface;

/**
 * Represents the Byte datatype.
 *
 * @package Novaxis\Core\Syntax\Datatype
 */
class ByteType implements TypesInterface {
	/**
	 * @var string $dataTypeName The name of the datatype (Byte).
	 */
	public $dataTypeName = 'Byte';

	/**
     * @var mixed $value The value of the Byte.
     */
	private $value;

	/**
     * Set the value of the Byte.
     *
     * @param mixed $value The value of the Byte.
     * @return $this
     */
	public function setValue($value) {
		$this -> value = $value;

		return $this;
	}

	/**
     * Get the value of the Byte.
     *
     * @return mixed The value of the Byte.
     */
	public function getValue() {
		return $this -> value;
	}

	/**
     * Check if the value is valid for Byte conversion.
     *
     * @return bool True if the value is valid, false otherwise.
     */
	public function is() {
		return (
			$this -> isValidBinValue($this -> value)
			|| $this -> isValidByteValue($this -> value)
			|| $this -> isValidHexValue($this -> value)
		);
	}

	/**
     * Convert the value to the appropriate format.
     *
     * @throws ConversionErrorException If the value is not valid.
     * @return ByteType This instance with the converted value.
     */
	public function convertTo() {
		if (!$this -> is()) {
			throw new ConversionErrorException;
		}

		if ($this -> isValidByteValue($this -> value)) {
			$this -> value = $this -> parseByteValue($this -> value);
		} else if ($this->isValidHexValue($this -> value)) {
			$this -> value = $this -> parseHexValue($this -> value);
		} else if ($this->isValidBinValue($this -> value)) {
			$this -> value = $this -> parseBinValue($this -> value);
		}

		return $this;
	}

	/**
     * Check if the value is valid for Byte conversion.
     *
     * @param mixed $value The value to check.
     * @return bool True if the value is valid, false otherwise.
     */
	private function isValidByteValue($value) {
		return preg_match('/^\d+(\.\d+)?[YZEPTGMK]?[Bp]?$/i', $value);
	}

	/**
     * Check if the value is a valid hexadecimal value.
     *
     * @param mixed $value The value to check.
     * @return bool True if the value is valid, false otherwise.
     */
	private function isValidHexValue($value) {
		return preg_match('/^0x[0-9A-Fa-f]+$/', $value);
	}
	
	/**
     * Check if the value is a valid binary value.
     *
     * @param mixed $value The value to check.
     * @return bool True if the value is valid, false otherwise.
     */
	private function isValidBinValue($value) {
		return preg_match('/^0b[01]+$/', $value);
	}
	
	/**
     * Parse a hexadecimal value to decimal.
     *
     * @param mixed $value The value to parse.
     * @return int The parsed value.
     */
	private function parseHexValue($value) {
		return hexdec($value);
	}

	/**
     * Parse a binary value to decimal.
     *
     * @param mixed $value The value to parse.
     * @return int The parsed value.
     */
	private function parseBinValue($value) {
		return bindec(substr($value, 2)); // Remove "0b" prefix before conversion
	}

	/**
     * Parse a byte value with units to bytes.
     *
     * @param mixed $value The value to parse.
     * @return float|int The parsed value in bytes.
     */
	private function parseByteValue($value) {
		$multipliers = [
			'B' => 1,
			'KB' => 1024,
			'MB' => 1024 * 1024,
			'GB' => 1024 * 1024 * 1024,
			'TB' => 1024 * 1024 * 1024 * 1024,
			'PB' => 1024 * 1024 * 1024 * 1024 * 1024,
			'EB' => 1024 * 1024 * 1024 * 1024 * 1024 * 1024,
			'ZB' => 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024,
			'YB' => 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024,
		];

		preg_match('/^(\d+(\.\d+)?)([YZEPTGMKBp]*)$/i', $value, $matches);

		$numericValue = floatval($matches[1]);
		$unit = strtoupper($matches[3]);

		$value = null;
		if (isset($multipliers[$unit])) {
			$value = $numericValue * $multipliers[$unit];
		}
		$value = $value ?? $numericValue;

		if (strpos($value, '.')) {
            return (float) $value;
		} else {
			return (int) $value;
		}
	}
}