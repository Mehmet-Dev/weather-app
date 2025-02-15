<?php
// Loading necessary files
require_once __DIR__ . '/../controllers/WeatherController.php';

$route = $_get['route'] ?? 'home';

switch($route)
{
    case 'home':
        require_once __DIR__ . '/../views/home.php';
        break;
    
    case 'weather':
        $controller = new WeatherController();
        $controller->getWeather();
        break;
    default:
        require_once __DIR__ . '/../views/error.php';
        break;
}
?>