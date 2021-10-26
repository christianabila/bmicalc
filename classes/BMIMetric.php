<?php

namespace BMICalc\Classes;

use Exception;

/** BMI calculation for metric values. */
class BMIMetric extends BMI implements BMIInterface
{
	/** @var string DIMENSION */
	private const DIMENSION = "kg/m<sup>2</sup>";

	/**
	 * @param integer $height The person's height.
	 * @param float $weight The person's weight.
	 * @throws BMIException
	 */
	public function __construct($height, $weight)
	{	
		if(is_numeric($height) && $height > 0)
			$this->height = $height;
		
		else 
			throw new BMIException("Height has to be a numeric and greater than zero!");
		
		if(is_numeric($weight) && $weight > 0) 
			$this->weight = $weight;
		
		else 
			throw new BMIException("Weight has to be a numeric and greater than zero!");
	}	
	
	public function calculate()
	{
		try {	
			if(isset($this->height) && isset($this->weight))
				return round($this->weight/(($this->height*$this->height)/10000), 1);
			else {
				throw new BMIException("Height and weight must both be set!");
			}
		} catch(Exception $e) {
			throw new BMIException($e->getMessage());
		}
	}
	
	/**
	 * Sets the value of the attribute height.
	 * @param integer $height The person's height in centimeters.
	 * @return true on success, throws a BMIException otherwise
	 * @throws BMIException
	 */
	public function setHeight($height)
	{
		if(is_numeric($height) && $height > 0) {
			$this->$height = $height;
			return true;
		} else {
			throw new BMIException("Height must be a numeric and greater than zero!");
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
