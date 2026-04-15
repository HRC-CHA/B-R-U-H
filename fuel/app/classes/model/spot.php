<?php

class Model_Spot extends \Orm\Model
{
    protected static $_properties = array(
        'id',
        'user_id',
        'name',
        'postal_code',
        'created_at',
        'updated_at',
    );

    public function display_postal_code()
    {
        $clean = str_replace('-', '', $this->postal_code);
        if (strlen($clean) === 7) {
            return substr($clean, 0, 3) . '-' . substr($clean, 3);
        }
        return $clean;
    }

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

    protected static $_table_name = 'spots';
}