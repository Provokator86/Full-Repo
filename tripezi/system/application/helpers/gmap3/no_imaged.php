<?php
header('Content-Type: image/png');

//source image path.Must be a png image.
$imgname	=	'icon/pin.png';
//get source image width/height.
list($width, $height) = getimagesize($imgname); 
//creating image.
$src_im	=	@imagecreatefrompng($imgname);
// Create the image
$im = imagecreatetruecolor($width, $height);
//set transparency of image.
$transparencyIndex = imagecolortransparent($src_im);
$transparencyColor = array('red' => 1, 'green' => 196, 'blue' => 255);

if ($transparencyIndex >= 0) {
	$transparencyColor    = imagecolorsforindex($src_im, $transparencyIndex);   
}

$transparencyIndex    = imagecolorallocate($im, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']);

imagefill($im, 0, 0, $transparencyIndex);
imagecolortransparent($im, $transparencyIndex); 

//copy source image to destination image. 
imagecopy($im, $src_im, 0, 0, 0, 0, $width, $height); 

// Create some colors. used ad font color.
$white = imagecolorallocate($im, 254, 254, 254);

// The number to write.
$text = $_GET['number'];

// number font path
$font = 'font/arial.ttf';

// Add some shadow to the number.
imagettftext($im, 10, 0, 0, 0, $white, $font, $text);

// set left position of number for single digit or double digit.
$left	=	$text>9?4:9;
// Add the number
imagettftext($im, 10, 0, $left, 17, $white, $font, $text.'');

// Using imagepng() results in clearer text compared with imagejpeg()

imagepng($im);
imagedestroy($im);