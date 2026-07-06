<?php

namespace App\Support;

use Carbon\Carbon;

class DateFormatter
{
    public static function idDate($date, string $format = 'd F Y'): string
    {
        if (empty($date)) {
            return '-';
        }

        $carbon = $date instanceof Carbon
            ? $date
            : Carbon::parse($date);

        $carbon->locale('id');

        return $carbon->translatedFormat($format);
    }
}