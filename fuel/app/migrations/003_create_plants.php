<?php

namespace Fuel\Migrations;

class create_plants
{
    public function up()
    {
        \DBUtil::create_table('plants', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'spot_id' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true), 
            'name' => array('constraint' => 50, 'type' => 'varchar'),
            'species' => array('constraint' => 30, 'type' => 'varchar'), 
            'size' => array('constraint' => 50, 'type' => 'varchar'),
            'pot_size' => array('constraint' => 50, 'type' => 'varchar'),
            'last_watered_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true), 
            'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true), 
        ), array('id'));
    }

    public function down() { \DBUtil::drop_table('plants'); }
}