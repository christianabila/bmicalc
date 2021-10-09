<?php

namespace BMICalc\Classes;

class BMIEmpirical extends BMI implements BMIInterface
{
	private const DIMENSION = "lbs/inch<sup>2</sup>";
	/**
	 * @param integer $heightFt The part of the person's height in feet.
	 * @param integer $heightInch The part of the person's height in inch.
	 * @param float $weight The person's weight in pounds.
	 * @throws BMIException
	 */
	public function __construct($heightFt, $heightInch, $weight)
	{
		try {
			//height is converted to inch and further processed as such
			if(!(is_numeric($heightFt) && $heightFt > 0))
				throw new BMIException("Feet part of height has to be a numeric and greater than zero!");
			
			if(is_numeric($heightInch) && $heightInch > 0) {
				$this->setHeight($heightFt*12 + $heightInch);
			} else {
				throw new BMIException("Inch part of height has to be a numeric and greater than zero!");
			}
			
			if(is_numeric($weight) && $weight > 0) {
				$this->weight = $weight;
			} else {
				throw new BMIException("Weight has to be a numeric and greater than zero!");
			}

		} catch (Exception $e) {
			throw new BMIException($e->getMessage());
		}
	}	
	
	public function calculate()
	{
		try {
			if(isset($this->height) && isset($this->weight))
				return round(($this->weight/($this->$height*$this->$height))*703, 1);
			
			else
				throw new BMIException("Height and weight must both be set.");
				
		} catch(Exception $e) {
			throw new BMIException($e->getMessage());
		}
	}

    /**
	 * Returns the dimension of the BMI.
	 * @return string
	 */
	public function getDimension()
	{
		return $this->DIMENSION;
	}
}
