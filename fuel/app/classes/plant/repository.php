<?php

class Plant_Repository
{
    public static function ids_for_spot($spot_id)
    {
        $rows = \DB::select('id')
            ->from('plants')
            ->where('spot_id', (int) $spot_id)
            ->execute()
            ->as_array();
        $ids = array();
        foreach ($rows as $r) {
            $ids[] = (int) $r['id'];
        }

        return $ids;
    }

    public static function for_spot($spot_id)
    {
        $rows = \DB::select(
            'id',
            'spot_id',
            'name',
            'species',
            'size',
            'pot_size',
            'last_watered_at',
            'created_at',
            'updated_at'
        )
            ->from('plants')
            ->where('spot_id', (int) $spot_id)
            ->order_by('id', 'asc')
            ->execute()
            ->as_array();

        return $rows;
    }

    public static function for_spot_ids(array $spot_ids, $order_by = 'asc')
    {
        if (empty($spot_ids)) {
            return array();
        }
        $dir = strtoupper($order_by) === 'DESC' ? 'desc' : 'asc';
        $ids = array_map('intval', $spot_ids);
        $rows = \DB::select(
            'id',
            'spot_id',
            'name',
            'species',
            'size',
            'pot_size',
            'last_watered_at',
            'created_at',
            'updated_at'
        )
            ->from('plants')
            ->where('spot_id', 'in', $ids)
            ->order_by('id', $dir)
            ->execute()
            ->as_array();

        return $rows;
    }

    public static function belongs_to_user($plant_id, $user_id)
    {
        $p = self::find($plant_id);
        if (!$p) {
            return false;
        }

        return \Spot_Repository::spot_belongs_to_user((int) $p['spot_id'], $user_id);
    }

    public static function find($id)
    {
        $row = \DB::select(
            'id',
            'spot_id',
            'name',
            'species',
            'size',
            'pot_size',
            'last_watered_at',
            'created_at',
            'updated_at'
        )
            ->from('plants')
            ->where('id', (int) $id)
            ->limit(1)
            ->execute()
            ->as_array();

        return !empty($row) ? $row[0] : null;
    }

    public static function create(array $data)
    {
        $now = time();
        $row = array(
            'spot_id'          => (int) $data['spot_id'],
            'name'             => (string) $data['name'],
            'species'          => (string) $data['species'],
            'size'             => (string) $data['size'],
            'pot_size'         => (string) $data['pot_size'],
            'last_watered_at'  => isset($data['last_watered_at']) ? (int) $data['last_watered_at'] : $now,
            'created_at'       => $now,
            'updated_at'       => $now,
        );
        list($id) = \DB::insert('plants')->set($row)->execute();

        return (int) $id;
    }

    public static function update($id, array $data)
    {
        $row = array(
            'spot_id'    => (int) $data['spot_id'],
            'name'       => (string) $data['name'],
            'species'    => (string) $data['species'],
            'size'       => (string) $data['size'],
            'pot_size'   => (string) $data['pot_size'],
            'updated_at' => time(),
        );
        \DB::update('plants')->set($row)->where('id', (int) $id)->execute();
    }

    public static function set_last_watered_at($id, $ts = null)
    {
        if ($ts === null) {
            $ts = time();
        }
        \DB::update('plants')
            ->set(array(
                'last_watered_at' => (int) $ts,
                'updated_at'      => time(),
            ))
            ->where('id', (int) $id)
            ->execute();
    }

    public static function delete($id)
    {
        $id = (int) $id;
        \DB::start_transaction();
        try {
            Growth_Repository::delete_for_plant($id);
            \DB::delete('plants')->where('id', $id)->execute();
            \DB::commit_transaction();
        } catch (\Exception $e) {
            \DB::rollback_transaction();
            throw $e;
        }
    }

    public static function delete_by_spot($spot_id)
    {
        \DB::delete('plants')->where('spot_id', (int) $spot_id)->execute();
    }
}
