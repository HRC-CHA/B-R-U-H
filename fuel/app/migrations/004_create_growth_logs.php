<?php

namespace Fuel\Migrations;

class create_growth_logs
{
    public function up()
    {
        \DBUtil::create_table('growth_logs', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'plant_id' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true),
            'height' => array('constraint' => 11, 'type' => 'int'), // Measurement in mm or cm
            'note' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
            'created_at' => array('constraint' => 11, 'type' => 'int'),
        ), array('id'));
    }

    public function down()
    {
        \DBUtil::drop_table('growth_logs');
    }
}