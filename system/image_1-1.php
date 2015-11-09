<?php

$imageURL = $_GET['url'];
header('Content-Type: image/jpeg');
$filename = $imageURL;
list($width, $height) = getimagesize($filename);

if ($width > $height) {
    $wh_s = $height;
    $s_h = 0;
    $s_w = (($width - $height) / 3.0) * 1;
} else {
    $wh_s = $width;
    $s_h = (($height - $width) / 3.0) * 1;
    $s_w = 0;
}

//echo "width: $width <br>"
// . "height: $height <br>"
// . "wh_s: $wh_s <br>"
// . "s_w: $s_w <br>"
// . "s_h: $s_h <br>";
//$new_width = 200;
//$new_height = 200;

$image_p = imagecreatetruecolor($wh_s, $wh_s);
$image = imagecreatefromjpeg($filename);
imagecopyresampled($image_p, $image, 0, 0, $s_w, $s_h, $wh_s, $wh_s, $wh_s, $wh_s);
imagejpeg($image_p, null, 100);
