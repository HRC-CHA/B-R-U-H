<?php

class Model_Plant extends \Orm\Model
{
    protected static $_properties = array(
        'id',
        'spot_id',
        'name',
        'species',
        'size',
        'pot_size',
        'last_watered_at',
        'created_at',
        'updated_at',
    );

    protected static $_has_many = array(
        'growth_logs' => array(
            'model_to' => 'Model_Growth',
            'key_from' => 'id',
            'key_to' => 'plant_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ),
    );

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_save'),
            'mysql_timestamp' => false,
        ),
    );

    protected static $_table_name = 'plants';
}
