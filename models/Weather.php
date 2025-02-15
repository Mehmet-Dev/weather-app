<?php

class Weather
{
    public string $country;
    public string $city;
    public string $condition;
    public string $icon;
    public float $temp;
    public float $feels_temp;
    public float $wind_speed;

    public function __construct(string $country, string $city, string $condition, string $icon, float $temp, float $feels_temp, float $wind_speed)
    {
        self::$country = $country;
        self::$city = $city;
        self::$condition = $condition;
        self::$icon = $icon;
        self::$temp = $temp;
        self::$feels_temp = $feels_temp;
        self::$wind_speed = $wind_speed;
    }
}