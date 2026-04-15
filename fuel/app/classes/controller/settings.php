<?php

class Controller_Settings extends Controller
{
    public function action_index()
    {
        if (!\Auth::check()) {
            \Response::redirect('auth/login');
        }

        $username = \Auth::get_screen_name();
        $email = \Auth::get_email();

        $data = array(
            'username' => $username,
            'email' => $email,
            'success_msg' => \Session::get_flash('success'),
            'error_msg' => \Session::get_flash('error'),
        );

        return \View::forge('settings/index', $data, false);
    }

    public function action_password()
    {
        if (!\Auth::check()) \Response::redirect('auth/login');

        if (\Input::method() == 'POST') {
            $old_password = \Input::post('old_password');
            $new_password = \Input::post('new_password');

            try {
                if (\Auth::change_password($old_password, $new_password)) {
                    \Session::set_flash('success', 'Password updated successfully! 🌿');
                } else {
                    \Session::set_flash('error', 'Incorrect current password. 🥀');
                }
            } catch (\Exception $e) {
                \Session::set_flash('error', 'Failed to update password. 😵‍💫');
            }
        }
        \Response::redirect('settings');
    }

    public function action_delete()
    {
        if (!\Auth::check()) \Response::redirect('auth/login');

        if (\Input::method() == 'POST') {
            $username = \Auth::get_screen_name();
            
            try {
                if (\Auth::delete_user($username)) {
                    \Auth::logout();
                    \Response::redirect('auth/login');
                } else {
                    \Session::set_flash('error', 'Failed to delete account.');
                    \Response::redirect('settings');
                }
            } catch (\Exception $e) {
                \Session::set_flash('error', 'Error occurred while deleting account.');
                \Response::redirect('settings');
            }
        }
    }
}