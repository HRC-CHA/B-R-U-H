<?php

class Helper_Postal
{
    /**
     *  spots.postal_code is VARCHAR(7). Strip non-digits, then cap at 7 to avoid "Data too long" SQL errors
     *  (e.g. 81900521 -> 8190052).
     */
    public static function normalize_for_storage($postal_code)
    {
        $d = preg_replace('/\D/', '', (string) $postal_code);
        if (strlen($d) > 7) {
            $d = substr($d, 0, 7);
        }

        return $d;
    }

    public static function format($postal_code)
    {
        $clean = str_replace('-', '', (string) $postal_code);
        if (strlen($clean) === 7) {
            return substr($clean, 0, 3) . '-' . substr($clean, 3);
        }

        return $clean;
    }
}
