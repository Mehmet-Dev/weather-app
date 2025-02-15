<?php
include_once('config/config.php');
include_once('includes/WeatherController.php');

$controller = new WeatherController();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <div class="centered-box">
        <?php $controller->retrieveWeatherData("London"); ?>
    </div>

    <?php include_once('views/footer.php') ?>
</body>
</html>