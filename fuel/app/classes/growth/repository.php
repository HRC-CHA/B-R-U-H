<?php

class Growth_Repository
{
    public static function delete_for_plant($plant_id)
    {
        \DB::delete('plant_growth_logs')
            ->where('plant_id', (int) $plant_id)
            ->execute();
    }

    public static function delete_for_plant_ids(array $plant_ids)
    {
        if (empty($plant_ids)) {
            return;
        }
        $ids = array_map('intval', $plant_ids);
        \DB::delete('plant_growth_logs')
            ->where('plant_id', 'in', $ids)
            ->execute();
    }

    public static function insert($plant_id, $height, $measured_at = null)
    {
        if ($measured_at === null) {
            $measured_at = time();
        }
        $data = array(
            'plant_id'    => (int) $plant_id,
            'height'      => (string) $height,
            'measured_at' => (int) $measured_at,
        );
        \DB::insert('plant_growth_logs')->set($data)->execute();
    }

    public static function latest_by_plant_ids(array $plant_ids)
    {
        if (empty($plant_ids)) {
            return array();
        }
        $map = array();
        foreach (array_map('intval', $plant_ids) as $pid) {
            if ($pid < 1) {
                continue;
            }
            $row = \DB::select('id', 'plant_id', 'height', 'measured_at')
                ->from('plant_growth_logs')
                ->where('plant_id', $pid)
                ->order_by('measured_at', 'desc')
                ->order_by('id', 'desc')
                ->limit(1)
                ->execute()
                ->as_array();
            if (!empty($row)) {
                $map[$pid] = $row[0];
            }
        }

        return $map;
    }

    public static function for_plant_ids_grouped(array $plant_ids)
    {
        if (empty($plant_ids)) {
            return array();
        }
        $ids = array_map('intval', $plant_ids);
        $rows = \DB::select('id', 'plant_id', 'height', 'measured_at')
            ->from('plant_growth_logs')
            ->where('plant_id', 'in', $ids)
            ->order_by('measured_at', 'asc')
            ->execute()
            ->as_array();

        $grouped = array();
        foreach ($rows as $r) {
            $pid = (int) $r['plant_id'];
            if (!isset($grouped[$pid])) {
                $grouped[$pid] = array();
            }
            $grouped[$pid][] = $r;
        }

        return $grouped;
    }
}
