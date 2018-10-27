<?php
function date_indonesia($tgl){
    $dt = new Carbon($tgl);
    setlocale(LC_TIME, 'IND');
    
    return $dt->formatLocalized('%d %B %Y %H:%M:%S');  
}