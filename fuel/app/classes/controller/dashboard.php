<?php

class Controller_Dashboard extends Controller
{
    public function action_index($id = null)
    {
        if (!\Auth::check()) \Response::redirect('auth/login');

        list($driver, $user_id) = \Auth::get_user_id();
        $username = \Auth::get_screen_name();
        $email = \Auth::get_email();

        $spots = \Model_Spot::find('all', array('where' => array('user_id' => $user_id)));

        $active_spot = null;
        if ($id) {
            $active_spot = \Model_Spot::find($id);
            if ($active_spot && $active_spot->user_id != $user_id) \Response::redirect('dashboard');
        } elseif (!empty($spots)) {
            $active_spot = reset($spots);
        }

        $plants = array();
        $plant_age_days = array();
        $weather_data = null;

        if ($active_spot) {
            $plants = \Model_Plant::find('all', array('where' => array('spot_id' => $active_spot->id)));
            $age_rows = \DB::select(
                'id',
                array(\DB::expr('CASE WHEN created_at IS NULL THEN NULL ELSE FLOOR((UNIX_TIMESTAMP() - created_at) / 86400) END'), 'age_days')
            )
                ->from('plants')
                ->where('spot_id', '=', $active_spot->id)
                ->execute()
                ->as_array();

            foreach ($age_rows as $row) {
                $pid = (int) $row['id'];
                $plant_age_days[$pid] = is_null($row['age_days']) ? null : (int) $row['age_days'];
            }
            
            if (!empty($active_spot->postal_code)) {
                $weather_data = \Model_Weather::get_weather($active_spot->postal_code);
            }
        }

        return \View::forge('dashboard/index', [
            'username' => $username,
            'email' => $email,
            'spots' => $spots,
            'active_spot' => $active_spot,
            'plants' => $plants,
            'plant_age_days' => $plant_age_days,
            'weather' => $weather_data,
        ], false);
    }

    public function action_rain_data($spot_id = null)
    {
        if (!\Auth::check()) return \Response::forge(json_encode(['error' => 'Unauthorized']), 401, ['Content-Type' => 'application/json']);
        list($driver, $user_id) = \Auth::get_user_id();

        $spot = \Model_Spot::find($spot_id);
        if (!$spot) return \Response::forge(json_encode(['error' => 'Spot not found']), 404, ['Content-Type' => 'application/json']);
        if ((int)$spot->user_id !== (int)$user_id) {
            return \Response::forge(json_encode(['error' => 'Forbidden']), 403, ['Content-Type' => 'application/json']);
        }

        try {
            $weather = \Model_Weather::get_weather($spot->postal_code);
            $slot_seconds = (int) \Config::get('weather.rain_slot_seconds', 600);
            if ($slot_seconds < 1) {
                $slot_seconds = 600;
            }
            
            $chart_data = [];
            $current_time = time();

            if (is_array($weather) && isset($weather['forecast']) && is_array($weather['forecast'])) {
                foreach ($weather['forecast'] as $idx => $f) {
                    $chart_data[] = [
                        'time' => date('H:i', $current_time + ($idx * $slot_seconds)),
                        'rainfall' => (float)($f['rainfall'] ?? 0)
                    ];
                }
            } else {
                $chart_data = [];
            }

            return \Response::forge(json_encode($chart_data), 200, array('Content-Type' => 'application/json'));

        } catch (\Exception $e) {
            \Log::error('Rain Data API Error: '.$e->getMessage());
            return \Response::forge(json_encode(['error' => 'Server Error', 'message' => $e->getMessage()]), 500, ['Content-Type' => 'application/json']);
        }
    }
}