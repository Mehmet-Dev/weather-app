<?php
session_start();
include 'Weather.php';
include 'CountryCodes.php';

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

        if (isset($data['cod']) && $data['cod'] == 404) {
            return false;
        } else {
            $country = COUNTRY_CODES[$data['sys']['country']];
            $condition = $data['weather'][0]['main'];
            $icon = $data['weather'][0]['icon'];
            $temp = self::convertUnit($data['main']['temp'], self::checkSession());
            $feels = self::convertUnit($data['main']['feels_like'], self::checkSession());
            $wind = $data['wind']['speed'];

            return new Weather($country, $cityName, $condition, $icon, $temp, $feels, $wind);
        }
    }

    public static function convertUnit(float $num, string $unit)
    {
        switch ($unit) {
            case 'C':
                return $num - 273.15;
            case 'F':
                return ($num - 273.15) * 1.8 + 32;
        }
    }

    public static function checkSession()
    {
        if($_SESSION['viewInCelsius'])
        {
            return 'C';
        } else return 'F';
    }
}
