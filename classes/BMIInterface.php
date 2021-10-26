<?php

namespace BMICalc\Classes;

interface BMIInterface
{
	/** 
	 * Calculates the BMI. Requires height and weight to be set.
	 * @return float The BMI on success.
	 * @throws BMIException 
	 */
	public function calculate();

	/**
	 * Returns the dimension of the calculated BMI.
	 * @return string The dimension.
	 */
	public function getDimension();
}
