<?php

namespace Fuel\Migrations;

class Add_auth_fields
{
    public function up()
    {
        \DBUtil::add_fields('users', array(
            'username' => array('constraint' => 50, 'type' => 'varchar'),
            'login_hash' => array('constraint' => 255, 'type' => 'varchar'),
            'profile_fields' => array('type' => 'text'),
        ));
    }

    public function down()
    {
        \DBUtil::drop_fields('users', array('username', 'login_hash', 'profile_fields'));
    }
}
