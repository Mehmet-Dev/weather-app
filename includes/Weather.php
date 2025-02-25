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
        $this->country = $country;
        $this->city = $city;
        $this->condition = $condition;
        $this->icon = $icon;
        $this->temp = $temp;
        $this->feels_temp = $feels_temp;
        $this->wind_speed = $wind_speed;
    }
}
