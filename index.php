<?php
include_once('includes/WeatherController.php');

if(!isset($_SESSION['viewInCelsius'])) // If it's not already initialized, set it
{
    $_SESSION['viewInCelsius'] = true;
}

if($_SESSION['viewInCelsius']) // if it's true, change some parts of the website around
{
    $string = "View in F";
    $unit = "C";
} else
{
    $string = "View in C";
    $unit = "F";
}

if (isset($_GET['city-name'])) { // If no city name is provided show London by default
    $cityName = $_GET['city-name'];
} else $cityName = "London";
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
        <?php
        $weather = retrieveWeatherData($cityName); // Get weather data
        if (!$weather) { // If the city hasn't been found or any other error, show error message.
            echo '<button class="no-style" id="different-city">City not found... Search for different city</button>';
        } else {
        ?>

            <div class="weather-container">
                <div class="icon-box">
                    <img src="https://openweathermap.org/img/wn/<?php echo $weather->icon; ?>@2x.png" alt="Weather Icon">
                </div>

                <div class="details-box">
                    <h2><?php echo $weather->country; ?> - <?php echo $weather->city; ?></h2>
                    <p>Condition: <?php echo $weather->condition; ?></p>
                    <p>Temperature: <?php echo round($weather->temp, 1) . " $unit"; ?> </p>
                    <p>Feels Like: <?php echo round($weather->feels_temp, 1) . " $unit" ?></p>
                    <p>Wind Speed: <?php echo $weather->wind_speed; ?> m/s, <?php echo windSpeedMessage($weather->wind_speed); ?></p>
                    <p><a class="no-styling" href="changeUnits.php"><?php echo $string; ?></a></p>
                    <button class="no-style" id="different-city">Search for different city</button>
                </div>
            </div>
        <?php } ?>
    </div>

    <?php include_once('views/footer.php') ?>
    <script src="js/jquery.js"></script>
    <script src="js/script.js"></script>
</body>

</html>