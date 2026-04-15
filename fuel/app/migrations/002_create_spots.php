<?php

namespace Fuel\Migrations;

class create_spots
{
    public function up()
    {
        \DBUtil::create_table('spots', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'user_id' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true),
            'name' => array('constraint' => 20, 'type' => 'varchar'), 
            'postal_code' => array('constraint' => 7, 'type' => 'varchar'),
            'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true), 
        ), array('id'));
    }

    public function down() { \DBUtil::drop_table('spots'); }
}