<?php
function hide_img($path, $str) {
    $im = imagecreatefrompng($path);
    $sx = imagesx($im); $sy = imagesy($im);

    $len = strlen($str);  // 字节长度
    if ($len * 8 > ($sx * $sy - 1) * 3)  // 1pixel = 3component
        return ['msg' => '信息长度超出隐写空间'];

    // 一个像素点用于保存长度
    // 长度的值 最大为：2^(3*8) - 1 = 16777215 = 500万个汉字
    imagesetpixel($im, $sx-1, $sy-1, $len);

    $bytes = [];
    for($i=0;$i<$len;$i++)
        $bytes[] = ord($str[$i]);
    $x = $y = $off = 0;  // off: 像素内偏移，取值0, 1, 2
    $comp = 'rgb';
    foreach ($bytes as $byte) {
        $mask = 0x80;
        for($i=0;$i<8;$i++) {
            if ($i)
                $mask >>= 1;
            $bit = $byte & $mask;

            if ($off == 0) {
                $pix = imagecolorat($im, $x, $y);
                $r = ($pix >> 16) & 0xFF;
                $g = ($pix >> 8) & 0xFF;
                $b = $pix & 0xFF;
            }
            $com_name = $comp[$off++];
            if ($bit) {
                $$com_name |= 1;
            } else {
                $$com_name &= 0xFE;
            }
            if ($off == 3) {
                $pix = $b + ($g << 8) + ($r << 16);
                imagesetpixel($im, $x, $y, $pix);
                $off=0; $x++;
                if ($x >= $sx) {
                    $y++; $x=0;
                }
            }
        }
    }
    imagepng($im, $path);
    imagedestroy($im);
    return ['msg' => '隐写成功'];
}

function get_info($path) {
    $im = imagecreatefrompng($path);
    $sx = imagesx($im);
    $sy = imagesy($im);
    $len = imagecolorat($im, $sx-1, $sy-1);

    $x = $y = $off = 0;
    $comp = 'rgb';
    $str = '';
    for($i=0; $i<$len; $i++) {
        $byte = 0;
        for($j=0; $j<8; $j++) {
            if ($off == 0) {
                $pix = imagecolorat($im, $x, $y);
                $r = ($pix >> 16) & 0xFF;
                $g = ($pix >> 8) & 0xFF;
                $b = $pix & 0xFF;
            }
            $com_name = $comp[$off++];
            $byte = $byte * 2 + ($$com_name & 1);
            if ($off == 3) {
                $off=0; $x++;
                if ($x >= $sx) {
                    $y++; $x=0;
                }
            }
        }
        $str .= chr($byte);
    }
    return $str;
}