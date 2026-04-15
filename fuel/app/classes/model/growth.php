<?php
class Model_Growth extends \Orm\Model
{
    protected static $_properties = array(
        'id',
        'plant_id',
        'height',
        'measured_at',
    );

    protected static $_table_name = 'plant_growth_logs';
}