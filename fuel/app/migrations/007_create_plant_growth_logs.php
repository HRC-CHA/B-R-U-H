<?php

namespace Fuel\Migrations;

class Create_plant_growth_logs
{
	public function up()
	{
		\DBUtil::create_table('plant_growth_logs', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'plant_id' => array('constraint' => 11, 'type' => 'int'),
			'height' => array('constraint' => 50, 'type' => 'varchar'),
			'measured_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('plant_growth_logs');
	}
}