<?php

// 求逆元
function reverse($p, $q) {
    $k = 1; $d = null;
    while ($k++) {
        if((1+$k * $q) % $p==0){
            $d = (1 + $k * $q) / $p;
            break;
        }
    }
    return $d;
}

function gcd($x, $y) {
    while($y) {
        $t = $x % $y;
        $x = $y;
        $y = $t;
    }
    return $x;
}

// 获得一个“合适”的与fi互素的数
function get_prime($last, $fi) {
    while (1) {
        $gcd_val = gcd($last, $fi);
        if ($gcd_val == 1) break;
        $last /= $gcd_val;
    }
    return $last;
}