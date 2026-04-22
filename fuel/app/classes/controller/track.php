<?php

class Controller_Track extends Controller
{
    public function before()
    {
        parent::before();
        if (!\Auth::check()) {
            \Response::redirect('auth/login');
        }
    }

    public function action_index()
    {
        $auth = \Auth::instance();
        $user_data = $auth->get_user_id();
        $user_id = $user_data[1];
        $username = \Auth::get_screen_name();
        $email = \Auth::get_email();

        $spots = \Spot_Repository::all_for_user($user_id, 'asc');
        $spot_ids = array_keys($spots);
        if (empty($spot_ids)) {
            $spot_ids = array(0);
        }

        $plants = \Plant_Repository::for_spot_ids($spot_ids, 'asc');
        $plant_ids = array();
        foreach ($plants as $p) {
            $plant_ids[] = (int) $p['id'];
        }
        $logs_by_plant = \Growth_Repository::for_plant_ids_grouped($plant_ids);
        foreach ($plants as $i => $p) {
            $pid = (int) $p['id'];
            $plants[$i]['growth_logs'] = isset($logs_by_plant[$pid]) ? $logs_by_plant[$pid] : array();
        }

        foreach ($spots as $sid => $spot) {
            $spots[$sid]['display_postal'] = \Helper_Postal::format($spot['postal_code']);
        }

        $data = array(
            'username' => $username,
            'email'    => $email,
            'spots'    => $spots,
            'plants'   => $plants,
        );

        return \View::forge('track/index', $data, false);
    }
}
