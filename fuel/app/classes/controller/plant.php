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
            $plant = Model_Plant::forge(array(
                'spot_id' => \Input::post('spot_id'),
                'name' => \Input::post('name'),
                'species' => \Input::post('species'),
                'size' => \Input::post('size'),
                'pot_size' => \Input::post('pot_size'),
                'last_watered_at' => time(),
            ));

            if ($plant and $plant->save()) {
                if (!empty($plant->size)) {
                    $log = \Model_Growth::forge(array(
                        'plant_id'    => $plant->id,
                        'height'      => $plant->size,
                        'measured_at' => time(),
                    ));
                    $log->save();
                }
                \Response::redirect('track');
            }
        }
    }

    public function action_water($id = null)
    {
        $plant = \Model_Plant::find($id);
        if ($plant) {
            $plant->last_watered_at = time();
            if ($plant->save()) {
                if (\Input::is_ajax()) {
                    return \Response::forge(json_encode(array('status' => 'success')), 200, array('Content-Type' => 'application/json'));
                }
                \Response::redirect('dashboard');
            }
        }
    }

    public function action_delete($id = null)
    {
        if (\Input::method() == 'POST') {
            $plant = \Model_Plant::find($id);
            if ($plant) { $plant->delete(); }
        }
        \Response::redirect('track');
    }

    public function action_update($id = null)
    {
        if (\Input::method() == 'POST') {
            $plant = \Model_Plant::find($id);
            if ($plant) {
                $plant->spot_id = \Input::post('spot_id');
                $plant->name = \Input::post('name');
                $plant->species = \Input::post('species');
                $plant->size = \Input::post('size');
                $plant->pot_size = \Input::post('pot_size');
                
                if ($plant->save()) {
                    $log = \Model_Growth::forge(array(
                        'plant_id'    => $plant->id,
                        'height'      => $plant->size, 
                        'measured_at' => time(),       
                    ));
                    $log->save();
                }
            }
        }
        \Response::redirect('track');
    }
}