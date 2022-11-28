<?php

namespace BMICalc;

require __DIR__ . "/vendor/autoload.php";

use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;

session_start();

include_once 'config.php';

if (!isset($_SESSION['selection'])) {
    $_SESSION['selection'] = 1;
}

try {
    if (isset($_POST['weight']) && is_numeric($_POST['weight']) && isset($_POST['height']) && is_numeric($_POST['height'])) {
        $_SESSION['weight'] = $_POST['weight'];
        $_SESSION['height'] = $_POST['height'];

        if ($_POST['height'] === "0") {
            throw new \Exception("Can't divide by zero!");
        }

        $_SESSION['bmi'] = round($_POST['weight'] / (($_POST['height'] * $_POST['height']) / 10000), 1);
        $_SESSION['dimension'] = "kg/m<sup>2</sup>";

        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } elseif (isset($_POST['weightImperial']) && isset($_POST['heightFt']) && isset($_POST['heightInch'])) {
        $_SESSION['weightImperial'] = $_POST['weightImperial'];
        $_SESSION['heightFt'] = $_POST['heightFt'];
        $_SESSION['heightInch'] = $_POST['heightInch'];

        if (($_POST['heightFt'] * 12 + $_POST['heightInch']) == 0) {
            throw new \Exception("Can't divide by zero!");
        }

        $height = $_POST['heightFt'] * 12 + $_POST['heightInch'];

        $_SESSION['bmi'] = round(($_POST['weightImperial'] / ($height * $height)) * 703, 1);
        $_SESSION['dimension'] = "lbs/inch";
    }
} catch (\Exception $e) {
    $_SESSION['error'] = $e->getMessage();

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$mustacheEngine = new Mustache_Engine([
    'entity_flags' => ENT_QUOTES,
    'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/templates'),
]);

if (isset($_SESSION['bmi'])) {
    $bmi10 = $_SESSION['bmi'] * 10;

    if ($bmi10 < 185) {
        $underweight = 'green';
    } elseif ($bmi10 >= 185 && $bmi10 <= 249) {
        $normal = 'green';
    } elseif ($bmi10 >= 250 && $bmi10 <= 299) {
        $overweight = 'green';
    } elseif ($bmi10 >= 300 && $bmi10 <= 349) {
        $obese1 = 'green';
    } elseif ($bmi10 >= 350 && $bmi10 <= 399) {
        $obese2 = 'green';
    } elseif ($bmi10 >= 400) {
        $obese3 = 'green';
    }
} elseif (isset($_SESSION['error'])) {
    echo $_SESSION['error'];
    unset($_SESSION['error']);

    if (isset($_SESSION['height'])) {
        unset($_SESSION['weight']);
        unset($_SESSION['height']);
    } elseif (isset($_SESSION['heightFt'])) {
        unset($_SESSION['weightImperial']);
        unset($_SESSION['heightFt']);
        unset($_SESSION['heightInch']);
    }
}

$contextVariables = [
    'version' => $VERSION,
    'action' => $_SERVER['PHP_SELF'],
    'bmi' => isset($_SESSION['bmi']) ? $_SESSION['bmi'] : '',
    'dimension' => isset($_SESSION['dimension']) ? $_SESSION['dimension'] : '',
    'selectedTab' => isset($_SESSION['selectedTab']) ? $_SESSION['selectedTab'] : 1,
    'weight' => isset($_SESSION['weight']) ? $_SESSION['weight'] : '',
    'height' => isset($_SESSION['height']) ? $_SESSION['height'] : '',
    'weightImperial' => isset($_SESSION['weightImperial']) ? $_SESSION['weightImperial'] : '',
    'heightFt' => isset($_SESSION['heightFt']) ? $_SESSION['heightFt'] : '',
    'heightInch' => isset($_SESSION['heightInch']) ? $_SESSION['heightInch'] : '',
    'underweight' => isset($underweight) ? $underweight : '',
    'normal' => isset($normal) ? $normal : '',
    'overweight' => isset($overweight) ? $overweight : '',
    'obese1' => isset($obese1) ? $obese1 : '',
    'obese2' => isset($obese2) ? $obese2 : '',
    'obese3' => isset($obese3) ? $obese3 : '',
];
echo $mustacheEngine->render('main', $contextVariables);

if (isset($_SESSION['bmi'])) {
    unset($_SESSION['bmi']);
    unset($_SESSION['weight']);
    unset($_SESSION['height']);
    unset($_SESSION['weightImperial']);
    unset($_SESSION['heightFt']);
    unset($_SESSION['heightInch']);
    unset($_SESSION['dimension']);
}
