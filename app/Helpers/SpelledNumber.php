<?php
function spelled_number($currency) {
    $angka = array(false, 'satu ','dua ','tiga ','empat ','lima ','enam ','tujuh ','delapan ','sembilan ');
    $group = array(2 => 'ribu ', 3 => 'juta ', 4=> 'miliar ', 5 => 'triliyun ', 6 => 'kuadriliun ');
    $satuan = array(2 => 'puluh ', 3 => 'ratus ');
     
    $n = strlen($currency);
    $g = ceil($n/3);
    $currency = str_pad($currency,$g*3,'0',STR_PAD_LEFT);
     
    for($x=0; $x<$g; $x++) {
    $t = $g - $x;
    $c = ltrim(substr($currency,$x*3, 3),'0');
    $sub = false;
     
    $n = strlen($c);
    for($i=0; $i < $n; $i++) {
    $rpos = $n - $i;
    $gpos = (!$gpos = ($rpos % 3)) ? 3: $gpos;
     
    $a = $c[$i];
    $s = false;
    if($gpos==1 ) {
    $a = ($c[$i-1]==1 || !$a) ? false: $a;
    $a = ($a==1 && ($t==2 && $c==1)) ? 'se': $angka[$a];
    }
    elseif($gpos==2 && $a==1) {
    $a = ($c[$i+1]>1) ? $angka[$c[$i+1]]: 'se';
    $s = ($c[$i+1]>0) ? 'belas ': $satuan[$gpos];
    }
    elseif($gpos==2 && $a!=1) {
    $s = ($a) ? $satuan[$gpos]: false;
    $a = $angka[$a];
    }
    else {
    $s = ($a) ? $satuan[$gpos]: false;
    $a = ($a==1) ? 'se': $angka[$a];
    }
     
    $sub.= $a.$s;
    }
     
    $str.= $sub.(($c) ? $group[$t]: false);
    }
     
    return $str;
    }