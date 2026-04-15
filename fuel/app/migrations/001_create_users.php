<?php

namespace Fuel\Migrations;

class create_users
{
    public function up()
    {
        \DBUtil::create_table('users', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'email' => array('constraint' => 50, 'type' => 'varchar'),
            'password' => array('constraint' => 255, 'type' => 'varchar'),
            'group' => array('constraint' => 11, 'type' => 'int', 'default' => 1),
            'last_login' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
        ), array('id'));
        
        \DBUtil::create_index('users', 'email', 'email_unique', 'unique');
    }

    public function down()
    {
        \DBUtil::drop_table('users');
    }
}