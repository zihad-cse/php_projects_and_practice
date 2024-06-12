<?php
session_start();

function generateRandomString($length) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $randomString = '';
    $maxIndex = strlen($characters) - 1;

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $maxIndex)];
    }

    return $randomString;
}

$image = imagecreatetruecolor(120, 40);
$bgColor = imagecolorallocate($image, 255, 255, 255);
$textColor = imagecolorallocate($image, 0, 0, 0);
imagefilledrectangle($image, 0, 0, 120, 40, $bgColor);


$captcha_code = generateRandomString(5);
$_SESSION['captcha'] = $captcha_code;

imagestring($image, 5, 30, 10, $captcha_code, $textColor);
header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?>