<?php
session_start();

include 'Weather.php';
include 'config.php'; // Needed for hidden data wooooo


function retrieveWeatherData(string $cityName)
{
    $url = DEFAULT_LINK . "?q=$cityName&appid=" . API_KEY;

    $response = @file_get_contents($url);

    if ($response === false || !isset($http_response_header)) {
        return false;
    }

    if (!str_contains($http_response_header[0], "200")) {
        return false;
    }

    $data = json_decode($response, true);

    if (!$data || !isset($data['main'])) {
        return false;
    }

    $countryCode = $data['sys']['country'] ?? null;
    if ($countryCode === null || !isset($codes[$countryCode])) {
        $country = 'Unknown';
    } else {
        $country = $codes[$countryCode];
    }

    $condition = $data['weather'][0]['main'] ?? 'Unknown';
    $icon = $data['weather'][0]['icon'] ?? '01d';
    $temp = convertUnit($data['main']['temp'] ?? 0, checkSession());
    $feels = convertUnit($data['main']['feels_like'] ?? 0, checkSession());
    $wind = $data['wind']['speed'] ?? 0;

    return new Weather($country, $cityName, $condition, $icon, $temp, $feels, $wind);
}


function countryCodes()
{
    return ['AF' => 'Afghanistan', 'AL' => 'Albania', 'DZ' => 'Algeria', 'AS' => 'American Samoa', 'AD' => 'Andorra', 'AO' => 'Angola', 'AI' => 'Anguilla', 'AQ' => 'Antarctica', 'AG' => 'Antigua and Barbuda', 'AR' => 'Argentina', 'AM' => 'Armenia', 'AU' => 'Australia', 'AT' => 'Austria', 'AZ' => 'Azerbaijan', 'BS' => 'Bahamas', 'BH' => 'Bahrain', 'BD' => 'Bangladesh', 'BB' => 'Barbados', 'BY' => 'Belarus', 'BE' => 'Belgium', 'BZ' => 'Belize', 'BJ' => 'Benin', 'BM' => 'Bermuda', 'BT' => 'Bhutan', 'BO' => 'Bolivia', 'BA' => 'Bosnia and Herzegovina', 'BW' => 'Botswana', 'BR' => 'Brazil', 'BN' => 'Brunei', 'BG' => 'Bulgaria', 'BF' => 'Burkina Faso', 'BI' => 'Burundi', 'KH' => 'Cambodia', 'CM' => 'Cameroon', 'CA' => 'Canada', 'CV' => 'Cape Verde', 'KY' => 'Cayman Islands', 'CF' => 'Central African Republic', 'TD' => 'Chad', 'CL' => 'Chile', 'CN' => 'China', 'CO' => 'Colombia', 'KM' => 'Comoros', 'CG' => 'Congo - Brazzaville', 'CD' => 'Congo - Kinshasa', 'CR' => 'Costa Rica', 'CI' => 'Côte d’Ivoire', 'HR' => 'Croatia', 'CU' => 'Cuba', 'CY' => 'Cyprus', 'CZ' => 'Czech Republic', 'DK' => 'Denmark', 'DJ' => 'Djibouti', 'DM' => 'Dominica', 'DO' => 'Dominican Republic', 'EC' => 'Ecuador', 'EG' => 'Egypt', 'SV' => 'El Salvador', 'GQ' => 'Equatorial Guinea', 'ER' => 'Eritrea', 'EE' => 'Estonia', 'SZ' => 'Eswatini', 'ET' => 'Ethiopia', 'FJ' => 'Fiji', 'FI' => 'Finland', 'FR' => 'France', 'GA' => 'Gabon', 'GM' => 'Gambia', 'GE' => 'Georgia', 'DE' => 'Germany', 'GH' => 'Ghana', 'GR' => 'Greece', 'GD' => 'Grenada', 'GT' => 'Guatemala', 'GN' => 'Guinea', 'GW' => 'Guinea-Bissau', 'GY' => 'Guyana', 'HT' => 'Haiti', 'HN' => 'Honduras', 'HK' => 'Hong Kong', 'HU' => 'Hungary', 'IS' => 'Iceland', 'IN' => 'India', 'ID' => 'Indonesia', 'IR' => 'Iran', 'IQ' => 'Iraq', 'IE' => 'Ireland', 'IL' => 'Israel', 'IT' => 'Italy', 'JM' => 'Jamaica', 'JP' => 'Japan', 'JO' => 'Jordan', 'KZ' => 'Kazakhstan', 'KE' => 'Kenya', 'KI' => 'Kiribati', 'KW' => 'Kuwait', 'KG' => 'Kyrgyzstan', 'LA' => 'Laos', 'LV' => 'Latvia', 'LB' => 'Lebanon', 'LS' => 'Lesotho', 'LR' => 'Liberia', 'LY' => 'Libya', 'LI' => 'Liechtenstein', 'LT' => 'Lithuania', 'LU' => 'Luxembourg', 'MO' => 'Macao', 'MG' => 'Madagascar', 'MW' => 'Malawi', 'MY' => 'Malaysia', 'MV' => 'Maldives', 'ML' => 'Mali', 'MT' => 'Malta', 'MH' => 'Marshall Islands', 'MR' => 'Mauritania', 'MU' => 'Mauritius', 'MX' => 'Mexico', 'FM' => 'Micronesia', 'MD' => 'Moldova', 'MC' => 'Monaco', 'MN' => 'Mongolia', 'ME' => 'Montenegro', 'MA' => 'Morocco', 'MZ' => 'Mozambique', 'MM' => 'Myanmar', 'NA' => 'Namibia', 'NR' => 'Nauru', 'NP' => 'Nepal', 'NL' => 'Netherlands', 'NZ' => 'New Zealand', 'NI' => 'Nicaragua', 'NE' => 'Niger', 'NG' => 'Nigeria', 'NO' => 'Norway', 'OM' => 'Oman', 'PK' => 'Pakistan', 'PW' => 'Palau', 'PA' => 'Panama', 'PG' => 'Papua New Guinea', 'PY' => 'Paraguay', 'PE' => 'Peru', 'PH' => 'Philippines', 'PL' => 'Poland', 'PT' => 'Portugal', 'QA' => 'Qatar', 'RO' => 'Romania', 'RU' => 'Russia', 'RW' => 'Rwanda', 'WS' => 'Samoa', 'SA' => 'Saudi Arabia', 'SN' => 'Senegal', 'RS' => 'Serbia', 'SC' => 'Seychelles', 'SL' => 'Sierra Leone', 'SG' => 'Singapore', 'SK' => 'Slovakia', 'SI' => 'Slovenia', 'SB' => 'Solomon Islands', 'SO' => 'Somalia', 'ZA' => 'South Africa', 'KR' => 'South Korea', 'ES' => 'Spain', 'LK' => 'Sri Lanka', 'SD' => 'Sudan', 'SR' => 'Suriname', 'SE' => 'Sweden', 'CH' => 'Switzerland', 'SY' => 'Syria', 'TW' => 'Taiwan', 'TJ' => 'Tajikistan', 'TZ' => 'Tanzania', 'TH' => 'Thailand', 'TL' => 'Timor-Leste', 'TG' => 'Togo', 'TO' => 'Tonga', 'TT' => 'Trinidad and Tobago', 'TN' => 'Tunisia', 'TR' => 'Turkey', 'TM' => 'Turkmenistan', 'TV' => 'Tuvalu', 'UG' => 'Uganda', 'UA' => 'Ukraine', 'AE' => 'United Arab Emirates', 'GB' => 'United Kingdom', 'US' => 'United States', 'UY' => 'Uruguay', 'UZ' => 'Uzbekistan', 'VU' => 'Vanuatu', 'VE' => 'Venezuela', 'VN' => 'Vietnam', 'YE' => 'Yemen', 'ZM' => 'Zambia', 'ZW' => 'Zimbabwe'];
}

function convertUnit(float $num, string $unit)
{
    switch ($unit) {
        case 'C':
            return round($num - 273.15, 2);
        case 'F':
            return round(($num - 273.15) * 1.8 + 32, 2);
        default:
            return $num;
    }
}

function checkSession()
{
    return (isset($_SESSION['viewInCelsius']) && $_SESSION['viewInCelsius']) ? 'C' : 'F';
}

function windSpeedMessage($windSpeed)
{
    $windSpeedKmh = $windSpeed * 3.6;

    $slowMessages = [
        "It's a calm day, no wind to worry about!",
        "The wind is barely noticeable – it's a still day!",
        "A perfect day for a walk in calm weather!"
    ];

    $mediumMessages = [
        "A light breeze is blowing – it’s a pleasant day!",
        "It's a bit breezy, but nothing too serious.",
        "You might feel a gentle breeze as you step outside."
    ];

    $highMessages = [
        "It’s pretty windy today, hold onto your hat!",
        "Strong winds are picking up, be prepared!",
        "The wind is howling today – better bundle up!"
    ];

    if ($windSpeedKmh <= 10) {
        return $slowMessages[array_rand($slowMessages)];
    } elseif ($windSpeedKmh <= 30) {
        return $mediumMessages[array_rand($mediumMessages)];
    } else {
        return $highMessages[array_rand($highMessages)];
    }
}
