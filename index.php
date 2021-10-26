<?php

namespace BMICalc;

require(__DIR__."/vendor/autoload.php");

session_start();

include_once 'config.php';

if(!isset($_SESSION['selection']))
	$_SESSION['selection'] = 1;

try
{  
    if(isset($_POST['weight']) && is_numeric($_POST['weight']) && isset($_POST['height']) && is_numeric($_POST['height']))
    {       
        $_SESSION['weight'] = $_POST['weight'];
        $_SESSION['height'] = $_POST['height'];
        
        if($_POST['height'] === "0")
            throw new \Exception("Can't divide by zero!"); 
        
        $_SESSION['bmi'] = round($_POST['weight']/(($_POST['height']*$_POST['height'])/10000), 1);
        $_SESSION['dimension'] = "kg/m<sup>2</sup> ";
        
        header('Location: '.$_SERVER['PHP_SELF']);
        exit;
    }
    
    else if(isset($_POST['weightEmp']) && isset($_POST['heightFt']) && isset($_POST['heightInch']))
    {
        $_SESSION['weightEmp'] = $_POST['weightEmp'];
        $_SESSION['heightFt'] = $_POST['heightFt'];
        $_SESSION['heightInch'] = $_POST['heightInch'];
        
        if(($_POST['heightFt']*12 + $_POST['heightInch']) == 0)
            throw new \Exception("Can't divide by zero!"); 
        
        $height = $_POST['heightFt']*12 + $_POST['heightInch'];
        
        $_SESSION['bmi'] = round(($_POST['weightEmp']/($height*$height))*703, 1);
        $_SESSION['dimension'] = "lbs/inch";
    }
} catch(\Exception $e) {
    $_SESSION['error'] = $e->getMessage();   
    
    header('Location: '.$_SERVER['PHP_SELF']);
    exit;
}
?>
<!doctype html>
<html lang="de" ng-app>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <title>BMI Rechner</title>
        
         <script src='https://code.jquery.com/jquery-3.1.0.js' integrity='sha256-slogkvB1K3VOkzAI8QITxV3VzpOnkeNVsKvtkYLMjfk=' crossorigin='anonymous'></script>
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script> 
        <script src="app.js"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.8/angular.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col">
                    <header style="background-color:lightgrey;padding:10px">
                        <h1>BMI Rechner</h1>
                        <span style="text-size:8px">v<?=$VERSION?></span>
                    </header>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link <?=(isset($_SESSION['selection']) && $_SESSION['selection'] == 1 ? 'active': '' )?>" href="#metric" onclick="changeSelection(1)">Metrisch</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link <?=(isset($_SESSION['selection']) && $_SESSION['selection'] == 2 ? 'active': '' )?>" href="#empirical" onclick="changeSelection(2)">Empirisch</a>
                        </li>
                    </ul>
                    
                    <div class="tab-content">
                        <div id="metric" class="tab-pane container <?=(isset($_SESSION['selection']) && $_SESSION['selection'] == 1 ? 'active': '' )?>">
                            <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                                <div class="form-group">
                                    <label for="weight">Gewicht (kg):</label>
                                    <input type="number" name="weight" min="0.0" step="0.1" class="form-control" value="<?php if(isset($_SESSION['weight'])) echo $_SESSION['weight']; ?>">   
                                </div>
                                <div class="form-group">
                                    <label for="height">Gr&ouml;&szlig;e (cm):</label>
                                    <input type="number" name="height" min="0" step="1" class="form-control" value="<?php if(isset($_SESSION['height'])) echo $_SESSION['height']; ?>">   
                                </div>
                                <button type="submit" class="btn btn-success">Berechnen</button>
                            </form>
                        </div>
                        
                        <div id="empirical" class="tab-pane container <?=(isset($_SESSION['selection']) && $_SESSION['selection'] == 2 ? 'active': '' )?>">
                            <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                                <div class="form-group">
                                    <label for="weightEmp">Gewicht (lbs):</label>
                                    <input type="number" name="weightEmp" min="0.0" step="0.1" class="form-control" value="<?php if(isset($_SESSION['weightEmp'])) echo $_SESSION['weightEmp']; ?>">   
                                </div>
                                
                                <div class="form-group">
                                    <label for="heightFt">Ft:</label>
                                    <input type="number" name="heightFt" min="0" step="1" class="form-control" value="<?php if(isset($_SESSION['heightFt'])) echo $_SESSION['heightFt']; ?>">  
                                    
                                    <label for="heightInch">Inch:</label>
                                    <input type="number" name="heightInch" min="0" step="1" class="form-control" value="<?php if(isset($_SESSION['heightInch'])) echo $_SESSION['heightInch']; ?>">   
                                </div>
                                <button type="submit" class="btn btn-success">Berechnen</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <h2>
                    <?php
                        if(isset($_SESSION['bmi']))
                        {
                            echo "Ihr BMI: ".$_SESSION['bmi']." ".$_SESSION['dimension'];
							
                            unset($_SESSION['weight']);
                            unset($_SESSION['height']);
                            unset($_SESSION['weightEmp']);
                            unset($_SESSION['heightFt']);
                            unset($_SESSION['heightInch']);
                            unset($_SESSION['dimension']);
                        } 

                        elseif(isset($_SESSION['error']))
                        {
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            
                            if(isset($_SESSION['height']))
                            {
                                unset($_SESSION['weight']);
                                unset($_SESSION['height']);   
                            }
                            
                            elseif(isset($_SESSION['heightFt']))
                            {
                                unset($_SESSION['weightEmp']);
                                unset($_SESSION['heightFt']);
                                unset($_SESSION['heightInch']);
                            }
                        }
                    ?>
                    </h2>
              	</div>
              	<div class="col">
                    
                    <?php 
                    	if(isset($_SESSION['bmi']))
						{
							$bmi10 = $_SESSION['bmi']*10;

							echo "
							<table class='table'>
								<thead>
									<th>BMI</th>
									<th>Kategorie</th>
								</thead>
								<tbody>
									<tr style='".($bmi10 < 185 ? "background-color:green" : "")."'><td>unter 18,5</td><td>Untergewicht</td></tr>
									<tr style='".($bmi10 >= 185 && $bmi10 <= 249 ? "background-color:green" : "")."'><td>18,5 - 24,9</td><td>Normalgewicht</td></tr>
									<tr style='".($bmi10 >= 250 && $bmi10 <= 299 ? "background-color:green" : "")."'><td>25,0 - 29,9</td><td>&Uuml;bergewicht</td></tr>
									<tr style='".($bmi10 >= 300 && $bmi10 <= 349 ? "background-color:green" : "")."'><td>30,0 - 34,9</td><td>Fettleibigkeit 1</td></tr>
									<tr style='".($bmi10 >= 350 && $bmi10 <= 399 ? "background-color:green" : "")."'><td>35,0 - 39,9</td><td>Fettleibigkeit 2</td></tr>
									<tr style='".($bmi10 >= 400 ? "background-color:green" : "")."'><td>&uuml;ber 40</td><td>Fettleibigkeit 3</td></tr>
								</tbody>
							</table>";
							
							echo "<a href='http://www.euro.who.int/en/health-topics/disease-prevention/nutrition/a-healthy-lifestyle/body-mass-index-bmi' style='font-size:10px'>Quelle</a>";
							
							unset($_SESSION['bmi']);
						}
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
