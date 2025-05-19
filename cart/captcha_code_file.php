<?php
<?php
/*
* CAPTCHA code by Simon Jarvis (GPL)
* http://www.white-hat-web-design.co.uk/articles/php-captcha.php
*/
session_start();

// Settings
$image_width = 120;
$image_height = 40;
$characters_on_image = 6;
$font = 'monofont.ttf';
$possible_letters = '23456789bcdfghjkmnpqrstvwxyzBCDFGHJKMNPQRSTVWXYZ';
$random_dots = 0;
$random_lines = 20;
$captcha_text_color = "0x142864";
$captcha_noice_color = "0x142864";

// Generate code
$code = '';
for ($i = 0; $i < $characters_on_image; $i++) {
    $code .= substr($possible_letters, mt_rand(0, strlen($possible_letters) - 1), 1);
}

// Create image
$font_size = $image_height * 0.75;
$image = imagecreate($image_width, $image_height);

// Colors
$background_color = imagecolorallocate($image, 255, 255, 255);
$arr_text_color = hexrgb($captcha_text_color);
$text_color = imagecolorallocate($image, $arr_text_color['red'], $arr_text_color['green'], $arr_text_color['blue']);
$arr_noice_color = hexrgb($captcha_noice_color);
$image_noise_color = imagecolorallocate($image, $arr_noice_color['red'], $arr_noice_color['green'], $arr_noice_color['blue']);

// Noise: dots
for ($i = 0; $i < $random_dots; $i++) {
    imagefilledellipse($image, mt_rand(0, $image_width), mt_rand(0, $image_height), 2, 3, $image_noise_color);
}

// Noise: lines
for ($i = 0; $i < $random_lines; $i++) {
    imageline($image, mt_rand(0, $image_width), mt_rand(0, $image_height),
        mt_rand(0, $image_width), mt_rand(0, $image_height), $image_noise_color);
}

// Add text
$textbox = imagettfbbox($font_size, 0, $font, $code);
$x = ($image_width - $textbox[4]) / 2;
$y = ($image_height - $textbox[5]) / 2;
imagettftext($image, $font_size, 0, $x, $y, $text_color, $font, $code);

// Output image
header('Content-Type: image/jpeg');
imagejpeg($image);
imagedestroy($image);
$_SESSION['6_letters_code'] = $code;

// Helper: hex to rgb
function hexrgb($hexstr) {
    $int = hexdec($hexstr);
    return [
        "red" => 0xFF & ($int >> 0x10),
        "green" => 0xFF & ($int >> 0x8),
        "blue" => 0xFF & $int
    ];
}
?>