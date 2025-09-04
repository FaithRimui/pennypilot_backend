<?php
header('Content-type: image/png');

$image = imagecreatetruecolor(200, 60);
$bg_color = imagecolorallocate($image, 0, 0, 0);
$text_color = imagecolorallocate($image, 255, 105, 180); // Pink

imagefilledrectangle($image, 0, 0, 200, 60, $bg_color);

$font_path = __DIR__ . '/OpenSans-Regular.ttf';
$text = "Test123";

imagettftext($image, 24, 0, 20, 40, $text_color, $font_path, $text);

imagepng($image);
imagedestroy($image);
?>
