<?php

use Illuminate\Support\Carbon;

function date_indonesia($date)
{
    setlocale(LC_ALL, 'id_ID.utf8');
    $date = Carbon::parse($date);
    return $date->formatLocalized('%A, %d %B %Y');
}
