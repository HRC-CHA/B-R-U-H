<?php

class Controller_Auth extends Controller
{
    public function action_register()
    {
        if (\Auth::check()) {
            \Response::redirect('dashboard');
        }

        if (\Input::method() == 'POST') {
            $username = \Input::post('username');
            $email = \Input::post('email');
            $password = \Input::post('password');
            $confirm_password = \Input::post('confirm_password');

            if ($password !== $confirm_password) {
                \Session::set_flash('error', 'Passwords do not match bruh. Try again! 🥀');
                \Response::redirect('auth/register');
            }

            try {
                $created = \Auth::create_user($username, $password, $email);
                
                if ($created) {
                    \Session::set_flash('success', 'Account created successfully! Please log in. 🌿');
                    \Response::redirect('auth/login');
                } else {
                    \Session::set_flash('error', 'Failed to create account.');
                }
            } catch (\SimpleUserUpdateException $e) {
                \Session::set_flash('error', 'Username or Email already exists.');
            } catch (\Exception $e) {
                \Session::set_flash('error', $e->getMessage());
            }
        }

        return \View::forge('auth/register');
    }

    public function action_login()
    {

        if (\Auth::check()) {
            \Response::redirect('dashboard'); 
        }

        if (\Input::method() == 'POST') {
            $email = \Input::post('email');
            $password = \Input::post('password');

            if (\Auth::login($email, $password)) {
                \Response::redirect('dashboard');
            } else {
                return "ERROR: Invalid email or password.";
            }
        }

        return \View::forge('auth/login');
    }

    public function action_logout()
    {
        \Auth::logout();
        \Response::redirect('auth/login');
    }
}