<?php

class Spot_Repository
{
    public static function all_for_user($user_id, $order_by = 'asc')
    {
        $dir = strtoupper($order_by) === 'DESC' ? 'desc' : 'asc';
        $rows = \DB::select('id', 'user_id', 'name', 'postal_code', 'created_at', 'updated_at')
            ->from('spots')
            ->where('user_id', (int) $user_id)
            ->order_by('id', $dir)
            ->execute()
            ->as_array();

        $out = array();
        foreach ($rows as $r) {
            $out[(int) $r['id']] = $r;
        }

        return $out;
    }

    public static function find($id)
    {
        $row = \DB::select('id', 'user_id', 'name', 'postal_code', 'created_at', 'updated_at')
            ->from('spots')
            ->where('id', (int) $id)
            ->limit(1)
            ->execute()
            ->as_array();

        return !empty($row) ? $row[0] : null;
    }

    public static function spot_belongs_to_user($spot_id, $user_id)
    {
        $s = self::find($spot_id);
        return $s !== null && (int) $s['user_id'] === (int) $user_id;
    }

    public static function create($user_id, $name, $postal_code)
    {
        $now = time();
        $data = array(
            'user_id'     => (int) $user_id,
            'name'        => (string) $name,
            'postal_code' => \Helper_Postal::normalize_for_storage($postal_code),
            'created_at'  => $now,
            'updated_at'  => $now,
        );
        list($id) = \DB::insert('spots')->set($data)->execute();

        return (int) $id;
    }

    public static function update($id, $name, $postal_code)
    {
        $data = array(
            'name'        => (string) $name,
            'postal_code' => \Helper_Postal::normalize_for_storage($postal_code),
            'updated_at'  => time(),
        );
        \DB::update('spots')->set($data)->where('id', (int) $id)->execute();
    }

    public static function delete_if_owner($id, $user_id)
    {
        $spot = self::find($id);
        if (!$spot || (int) $spot['user_id'] !== (int) $user_id) {
            return false;
        }

        return self::delete_cascade((int) $id) > 0;
    }

    public static function delete_cascade($spot_id)
    {
        $spot_id = (int) $spot_id;
        $plant_ids = Plant_Repository::ids_for_spot($spot_id);

        \DB::start_transaction();
        try {
            if (!empty($plant_ids)) {
                Growth_Repository::delete_for_plant_ids($plant_ids);
            }
            Plant_Repository::delete_by_spot($spot_id);
            \DB::delete('spots')->where('id', $spot_id)->execute();
            \DB::commit_transaction();
        } catch (\Exception $e) {
            \DB::rollback_transaction();
            throw $e;
        }

        return 1;
    }
}
