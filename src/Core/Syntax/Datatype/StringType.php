<?php
namespace Novaxis\Core\Syntax\Datatype;

use Novaxis\Core\Error\ConversionErrorException;
use Novaxis\Core\Syntax\Datatype\TypesInterface;

/**
 * Class StringType
 * Represents the String datatype in Novaxis.
 *
 * @package Novaxis\Core\Syntax\Datatype
 */
class StringType implements TypesInterface {
    /**
     * @var string The name of the data type.
     */
    public $dataTypeName = 'String';

    /**
     * @var string The value of the StringType instance.
     */
    private $value;

    /**
     * StringType constructor.
     * 
     * Initializes a new StringType instance.
     */
    public function __construct() {

    }

    /**
     * Sets the input value for the StringType instance.
     *
     * @param mixed $value The input value.
     * @return $this The current StringType instance.
     */
    public function setValue($value) {
        $this -> value = $value;

        return $this;
    }

    /**
     * Gets the value of the StringType instance.
     *
     * @return string The value of the StringType instance.
     */
    public function getValue() {
        return $this -> value;
    }

    /**
     * Checks if the current value is a valid representation of a string.
     *
     * @return bool True if the value is a valid string representation, false otherwise.
     */
    public function is() {
        return is_string($this -> value);
    }

    /**
     * Converts the current value to a proper string representation.
     *
     * @return $this The current StringType instance.
     * @throws ConversionErrorException If the current value is not a valid string representation.
     */
    public function convertTo() {
        if (!$this -> is()) {
            throw new ConversionErrorException;
        }
        
        $this -> value = (string) $this -> value;

        return $this;
    }
}