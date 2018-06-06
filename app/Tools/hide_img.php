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

    $bytes = [];  // 字节流
    for($i=0;$i<$len;$i++)  // 用户输入的字符串的每一个字符
        $bytes[] = ord($str[$i]);  // 字符被转换成0~255的数值，相当于字节
    $x = $y = $off = 0;  // x,y: 像素坐标，off: 像素内偏移，取值0, 1, 2
    $comp = 'rgb';  // 三个
    foreach ($bytes as $byte) {  // 对每一个字节
        $mask = 0x80;
        for($i=0;$i<8;$i++) {
            if ($i)
                $mask >>= 1;
            $bit = $byte & $mask;  // 从高位到低位，取出字节的每个bit

            if ($off == 0) {  // 取出像素中每个维度的值
                $pix = imagecolorat($im, $x, $y);
                $r = ($pix >> 16) & 0xFF;
                $g = ($pix >> 8) & 0xFF;
                $b = $pix & 0xFF;
            }
            $com_name = $comp[$off++];
            if ($bit) {
                $$com_name |= 1;  // 将某个维度的LSB置1
            } else {
                $$com_name &= 0xFE;  // 将某个维度的LSB置0
            }
            if ($off == 3) {  // 新的维度值合成像素，并重新写入
                $pix = $b + ($g << 8) + ($r << 16);
                imagesetpixel($im, $x, $y, $pix);
                $off=0; $x++;  // 移动到下一个像素
                if ($x >= $sx) {
                    $y++; $x=0;  // 移动到下一行
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

            // 取出每个维度(r g b)的LSB作为一个bit
            // 循环累乘法：顺序读每个bit，计算一个byte的真值
            $byte = $byte * 2 + ($$com_name & 1);
            if ($off == 3) {
                $off=0; $x++;
                if ($x >= $sx) {
                    $y++; $x=0;
                }
            }
        }
        // 根据byte的真值求出原字符；把所有字符用连接操作(.)还原成字符串
        $str .= chr($byte);
    }
    return $str;
}