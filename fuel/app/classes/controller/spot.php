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

            $spot = Model_Spot::forge(array(
                'user_id' => $user_id,
                'name' => \Input::post('name'),
                'postal_code' => str_replace('-', '', \Input::post('postal_code', '1000001')), 
            ));


            if ($spot and $spot->save()) {
                \Response::redirect('dashboard');
            } else {
                return "ERROR: Could not save Spot.";
            }
        }
    }

    public function action_update($id = null)
    {
        if (\Input::method() == 'POST') {
            $spot = \Model_Spot::find($id);
            
            if ($spot) {
                $spot->name = \Input::post('name');
                $spot->postal_code = \Input::post('postal_code');
                
                $spot->save();
            }
        }

        \Response::redirect('track');
    }

    public function action_delete($id = null)
    {
        if (\Input::method() == 'POST') {
            $spot = \Model_Spot::find($id);
            list($driver, $user_id) = \Auth::get_user_id();

            if ($spot && $spot->user_id == $user_id) {
                $plants = \Model_Plant::find('all', array('where' => array('spot_id' => $spot->id)));
                foreach($plants as $plant) {
                    $plant->delete();
                }

                $spot->delete();
            }
        }

        \Response::redirect('track');
    }
}