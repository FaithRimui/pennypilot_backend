<?php
session_start();

// Allow requests from React frontend
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: image/png');

// Generate CAPTCHA code
$code = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 5);
$_SESSION['captcha'] = $code;

// Create image
$image = imagecreatetruecolor(120, 40);
$bg = imagecolorallocate($image, 34, 34, 34); // dark
$text = imagecolorallocate($image, 255, 105, 180); // pink
$line = imagecolorallocate($image, 255, 255, 255); // white lines

imagefilledrectangle($image, 0, 0, 120, 40, $bg);

// Add noise lines
for ($i = 0; $i < 5; $i++) {
    imageline($image, rand(0, 120), rand(0, 40), rand(0, 120), rand(0, 40), $line);
}

// Use correct font path
$fontPath = __DIR__ . '/OpenSans-Regular.ttf';
imagettftext($image, 20, 0, 20, 30, $text, $fontPath, $code);

imagepng($image);
imagedestroy($image);
?>