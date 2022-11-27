<?php

namespace BMICalc;

	session_start();
	
	// current values for selection
	// 1 - metric
	// 2 - imperial
	if(isset($_POST['selectedTab']))
	{
		$_SESSION['selectedTab'] = $_POST['selectedTab'];
		// if tab = 1 convert from imperial to metric
		// if tab = 2 convert from metric to imperial
		
		/*
		 * 1 lbs = 0.45359 kg
		 * 1 kg = 2,204634141 lbs
		 * 
		 * 1 cm = 0,393700787401575 inch
		 * 1 inch = 2,54 cm
		 * 
		 * ft = inch * 0,083333
		 * */
		if($_POST['selectedTab'] == 1) {
			$_SESSION['height'] = $_POST['height']*2.54;
			$_SESSION['weight'] = $_POST['weight']*0.45359;	
		}
		
		else {
			$_SESSION['height'] = $_POST['height']*0.393700787401575;
			$_SESSION['weight'] = $_POST['weight']*2.204634141;	
		}
	}
