<?php
require '../models/Weather.php';
class WeatherController
{
    protected static $ch;
    public function __construct()
    {
        self::$ch = curl_init(self::$ch);
    }

    public static function retrieveWeatherData(string $cityName)
    {
        $url = DEFAULT_LINK . '?q=' . $cityName . '&appid=' . API_KEY;

        curl_setopt(self::$ch, CURLOPT_URL, $url);
        curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec(self::$ch);

        $data = json_decode($response, true);

        
    }

    public static function convertUnit(float $num, string $unit)
    {
        switch($unit)
        {
            case 'C':
                return $num - 273.15;
            case 'F':
                return ($num - 273.15) * 1.8 + 32;
        }
    }
}