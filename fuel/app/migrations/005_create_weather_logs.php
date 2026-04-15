<?php

namespace Fuel\Migrations;

class create_weather_logs
{
    public function up()
    {
        \DBUtil::create_table('weather_logs', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'room_id' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true),
            'temp' => array('constraint' => 11, 'type' => 'int'),
            'condition' => array('constraint' => 50, 'type' => 'varchar'), // e.g., "Sunny", "Rainy"
            'created_at' => array('constraint' => 11, 'type' => 'int'),
        ), array('id'));
    }

    public function down()
    {
        \DBUtil::drop_table('weather_logs');
    }
}