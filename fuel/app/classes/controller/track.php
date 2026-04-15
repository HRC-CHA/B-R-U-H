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

        $spots = \Model_Spot::find('all', array(
            'where' => array('user_id' => $user_id),
            'order_by' => array('id' => 'asc')
        ));

        $spot_ids = array_keys($spots) ?: array(0);
        $plants = \Model_Plant::find('all', array(
            'where' => array(array('spot_id', 'in', $spot_ids)),
            'order_by' => array('id' => 'asc')
        ));

        foreach ($spots as $spot) {
            $clean_code = str_replace('-', '', $spot->postal_code);
            $spot->display_postal_code = (strlen($clean_code) === 7) 
            ? substr($clean_code, 0, 3).'-'.substr($clean_code, 3) 
            : $clean_code;
        }

        $data = array(
            'username' => $username,
            'email' => $email,
            'spots' => $spots,
            'plants' => $plants
        );

        return \View::forge('track/index', $data, false);
    }
}