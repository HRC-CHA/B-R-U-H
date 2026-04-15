<?php

class Model_Weather extends \Model
{
    private static function get_keys() {
        return [
            'yahoo' => getenv('YAHOO_CLIENT_ID') ?: ($_ENV['YAHOO_CLIENT_ID'] ?? ''),
            'owm'   => getenv('OWM_API_KEY') ?: ($_ENV['OWM_API_KEY'] ?? '')
        ];
    }    
    
    public static function get_weather($postal_code)
    {
        $keys = self::get_keys();
        $yahoo_id = $keys['yahoo'];
        $owm_key = $keys['owm'];

        $cache_key = 'weather_' . md5($postal_code);

        try {
            return \Cache::get($cache_key);
        } catch (\CacheNotFoundException $e) {
        }

        $hybrid_data = [
            'temp' => null,
            'humidity' => 0,
            'condition' => 'Unknown',
            'icon' => 'cloud',
            'current_rainfall' => 0,
            'forecast' => []
        ];

        if (!$yahoo_id || !$owm_key) {
            return $hybrid_data;
        }

        $zip_url = "https://map.yahooapis.jp/search/zip/V1/zipCodeSearch?query=" . urlencode($postal_code) . "&appid=" . $yahoo_id . "&output=json";
        $zip_response = @file_get_contents($zip_url);
        
        if ($zip_response) {
            $zip_data = json_decode($zip_response, true);
            if (!empty($zip_data['Feature'][0]['Geometry']['Coordinates'])) {
                $coords = explode(',', $zip_data['Feature'][0]['Geometry']['Coordinates']);
                $lon = $coords[0];
                $lat = $coords[1];

                $weather_url = "https://map.yahooapis.jp/weather/V1/place?coordinates=" . $lon . "," . $lat . "&appid=" . $yahoo_id . "&output=json";
                $weather_response = @file_get_contents($weather_url);

                if ($weather_response) {
                    $weather_data = json_decode($weather_response, true);
                    if (!empty($weather_data['Feature'][0]['Property']['WeatherList']['Weather'])) {
                        $weathers = $weather_data['Feature'][0]['Property']['WeatherList']['Weather'];
                        $hybrid_data['current_rainfall'] = $weathers[0]['Rainfall'];
                        
                        foreach ($weathers as $w) {
                            $time_formatted = substr($w['Date'], 8, 2) . ':' . substr($w['Date'], 10, 2);
                            $hybrid_data['forecast'][] = [
                                'time' => $time_formatted,
                                'rainfall' => (float)$w['Rainfall']
                            ];
                        }
                    }
                }

                $owm_url = "https://api.openweathermap.org/data/2.5/weather?lat=" . $lat . "&lon=" . $lon . "&units=metric&appid=" . $owm_key;
                $owm_response = @file_get_contents($owm_url);
                
                if ($owm_response) {
                    $owm_data = json_decode($owm_response, true);
                    if (isset($owm_data['main'])) {
                        $hybrid_data['temp'] = (float)round($owm_data['main']['temp'], 1);
                        $hybrid_data['humidity'] = (int)$owm_data['main']['humidity'];
                        $hybrid_data['condition'] = 'Clear';
                        $hybrid_data['icon'] = 'sun';
                    }
                }
            }
        }

        if ($hybrid_data['current_rainfall'] > 0) {
            $hybrid_data['condition'] = 'Rainy';
            $hybrid_data['icon'] = 'cloud-rain';
        }

        if (!empty($hybrid_data['forecast'])) {
            \Cache::set($cache_key, $hybrid_data, 60);
        }

        return $hybrid_data;
    }
}