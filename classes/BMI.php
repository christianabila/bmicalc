<?php

namespace BMICalc\Classes;

abstract class BMI
{
    /** @var integer $height */
    private $height;

    /** @var float $weight */
    private $weight;

    /** @var float $bmi */
    private $bmi;

    /**
     * Returns the value of the attribute height.
     *
     * @return int The person's height in either inch or centimeters (integer), false (boolean) if the attribute is not set.
     * @throws BMIException
     */
    public function getHeight(): int
    {
        if (isset($this->height)) {
            return $this->height;
        }

        throw new BMIException('Height does not have a value!');
    }

    /**
     * Returns the value of the attribute weight.
     *
     * @return int The person's weight in either pounds or kilograms as float, boolean false otherwise.
     * @throws BMIException
     */
    public function getWeight(): int
    {
        if (isset($this->weight)) {
            return $this->weight;
        }

        throw new BMIException('Weight does not have a value!');
    }

    /**
     * Sets the value of the attribute weight.
     *
     * @param float $weight The person's weight in either pounds or kilograms.
     * @return true on success, throws a BMIException otherwise
     * @throws BMIException
     */
    public function setWeight($weight)
    {
        if (is_numeric($weight) && $weight > 0) {
            $this->weight = $weight;
            return true;
        }

        throw new BMIException("Weight must be a numeric and greater than zero!");
    }

    /**
     * Sets the value of the attribute weight.
     *
     * @param integer $height The person's weight in either inches or centimeters.
     * @return boolean true on success, throws a BMIException otherwise
     * @throws BMIException
     */
    public function setHeight($height)
    {
        if (is_numeric($height) && $height > 0) {
            $this->height = $height;
            return true;
        }

        throw new BMIException("Height must be a numeric and greater than zero!");
    }
}
