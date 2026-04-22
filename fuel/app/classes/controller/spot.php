<?php

class Controller_Spot extends Controller
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

            \Spot_Repository::create(
                $user_id,
                \Input::post('name'),
                str_replace('-', '', (string) \Input::post('postal_code', '1000001'))
            );
            \Response::redirect('dashboard');
        }
    }

    public function action_update($id = null)
    {
        if (\Input::method() == 'POST') {
            list($driver, $user_id) = \Auth::get_user_id();
            if (!\Spot_Repository::spot_belongs_to_user($id, $user_id)) {
                \Response::redirect('track');
            }

            \Spot_Repository::update((int) $id, \Input::post('name'), str_replace('-', '', (string) \Input::post('postal_code', '')));
        }

        \Response::redirect('track');
    }

    public function action_delete($id = null)
    {
        if (\Input::method() == 'POST') {
            list($driver, $user_id) = \Auth::get_user_id();
            \Spot_Repository::delete_if_owner((int) $id, $user_id);
        }

        \Response::redirect('track');
    }
}
