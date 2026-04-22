<?php

class Controller_Plant extends Controller
{
    public function before()
    {
        parent::before();
        if (!\Auth::check()) {
            \Response::redirect('auth/login');
        }
    }

    public function action_create()
    {
        if (\Input::method() == 'POST') {
            list($driver, $user_id) = \Auth::get_user_id();
            $spot_id = (int) \Input::post('spot_id');
            if (!\Spot_Repository::spot_belongs_to_user($spot_id, $user_id)) {
                \Response::redirect('track');
            }

            $new_id = \Plant_Repository::create(array(
                'spot_id'         => $spot_id,
                'name'            => \Input::post('name'),
                'species'         => \Input::post('species'),
                'size'            => \Input::post('size'),
                'pot_size'        => \Input::post('pot_size'),
                'last_watered_at' => time(),
            ));

            if ($new_id) {
                $size = trim((string) \Input::post('size'));
                if ($size !== '') {
                    \Growth_Repository::insert($new_id, $size, time());
                }
                \Response::redirect('track');
            }
        }
    }

    public function action_water($id = null)
    {
        list($driver, $user_id) = \Auth::get_user_id();
        if (!\Plant_Repository::belongs_to_user($id, $user_id)) {
            if (\Input::is_ajax()) {
                return \Response::forge(json_encode(array('status' => 'error')), 403, array('Content-Type' => 'application/json'));
            }
            \Response::redirect('dashboard');
        }

        \Plant_Repository::set_last_watered_at((int) $id, time());
        if (\Input::is_ajax()) {
            return \Response::forge(json_encode(array('status' => 'success')), 200, array('Content-Type' => 'application/json'));
        }
        \Response::redirect('dashboard');
    }

    public function action_delete($id = null)
    {
        if (\Input::method() == 'POST') {
            list($driver, $user_id) = \Auth::get_user_id();
            if (\Plant_Repository::belongs_to_user($id, $user_id)) {
                \Plant_Repository::delete((int) $id);
            }
        }
        \Response::redirect('track');
    }

    public function action_update($id = null)
    {
        if (\Input::method() == 'POST') {
            list($driver, $user_id) = \Auth::get_user_id();
            if (!\Plant_Repository::belongs_to_user($id, $user_id)) {
                \Response::redirect('track');
            }
            $spot_id = (int) \Input::post('spot_id');
            if (!\Spot_Repository::spot_belongs_to_user($spot_id, $user_id)) {
                \Response::redirect('track');
            }

            \Plant_Repository::update((int) $id, array(
                'spot_id'  => $spot_id,
                'name'     => \Input::post('name'),
                'species'  => \Input::post('species'),
                'size'     => \Input::post('size'),
                'pot_size' => \Input::post('pot_size'),
            ));

            $size = trim((string) \Input::post('size'));
            if ($size !== '') {
                \Growth_Repository::insert((int) $id, $size, time());
            }
        }
        \Response::redirect('track');
    }
}
