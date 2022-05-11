<?php

use Carbon\Carbon;

if (!function_exists('getYear')) {
    function getYear()
    {
        $date = Carbon::today();
        $month  =  $date->month;
        if ($month >= 9 && $month <= 12) {
            return $date->year . " - " . $date->year + 1;
        }
        return $date->year - 1 . " - " . $date->year;
    }
}
