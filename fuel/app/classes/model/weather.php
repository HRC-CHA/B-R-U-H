<?php

class Model_Weather extends \Model
{
    private static $yahoo_client_id = 'dmVyPTIwMjUwNyZpZD1OdkFaMDVNekNtJmhhc2g9Wm1ZMFpUWmpOV0ptTWpkbU16SXlOUQ';
    private static $owm_api_key = '3f6d3f63de6194e07fd88dc6c0cbac5b';

    public static function get_weather($postal_code)
    {
        $cache_key = 'weather_' . md5($postal_code);

        try {
            return \Cache::get($cache_key);
        } catch (\CacheNotFoundException $e) {
        }

        $zip_url = "https://map.yahooapis.jp/search/zip/V1/zipCodeSearch?query=" . urlencode($postal_code) . "&appid=" . self::$yahoo_client_id . "&output=json";
        $zip_response = @file_get_contents($zip_url);
        if (!$zip_response) return null;
        
        $zip_data = json_decode($zip_response, true);
        if (empty($zip_data['Feature'][0]['Geometry']['Coordinates'])) return null;

        $coords = explode(',', $zip_data['Feature'][0]['Geometry']['Coordinates']);
        $lon = $coords[0];
        $lat = $coords[1];

        $weather_url = "https://map.yahooapis.jp/weather/V1/place?coordinates=" . $lon . "," . $lat . "&appid=" . self::$yahoo_client_id . "&output=json";
        $weather_response = @file_get_contents($weather_url);
        
        $forecast_list = array();
        $current_rainfall = 0;

        if ($weather_response) {
            $weather_data = json_decode($weather_response, true);
            if (!empty($weather_data['Feature'][0]['Property']['WeatherList']['Weather'])) {
                $weathers = $weather_data['Feature'][0]['Property']['WeatherList']['Weather'];
                $current_rainfall = $weathers[0]['Rainfall'];
                
                foreach ($weathers as $w) {
                    $time_formatted = substr($w['Date'], 8, 2) . ':' . substr($w['Date'], 10, 2);
                    $forecast_list[] = array(
                        'time' => $time_formatted,
                        'rainfall' => $w['Rainfall']
                    );
                }
            }
        }

        $owm_url = "https://api.openweathermap.org/data/2.5/weather?lat=" . $lat . "&lon=" . $lon . "&units=metric&appid=" . self::$owm_api_key;
        $owm_response = @file_get_contents($owm_url);
        
        $temp = '--';
        $humidity = '--';
        
        if ($owm_response) {
            $owm_data = json_decode($owm_response, true);
            if (isset($owm_data['main'])) {
                $temp = round($owm_data['main']['temp'], 1);
                $humidity = $owm_data['main']['humidity'];
            }
        }

        $condition = 'Clear';
        $icon = 'sun';
        if ($current_rainfall > 0) {
            $condition = 'Rainy';
            $icon = 'cloud-rain';
        }

        $hybrid_data = array(
            'temp' => $temp,
            'humidity' => $humidity,
            'condition' => $condition,
            'icon' => $icon,
            'current_rainfall' => $current_rainfall,
            'forecast' => $forecast_list 
        );

        \Cache::set($cache_key, $hybrid_data, 60);

        return $hybrid_data;
    }
}