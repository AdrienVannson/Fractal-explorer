<?php
header("Content-type: image/png");

$size = 1 / pow(2, $_GET['z']);

$centerX = $_GET['x'] * $size + $size/2;
$centerY = -$_GET['y'] * $size - $size/2;

$type = $_GET['type'];
$nbMaxIterations = min($_GET['nbMaxIterations'], 100);

$HEIGHT = 256;
$WIDTH = 256;

$image = imagecreatetruecolor($WIDTH, $HEIGHT);

$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);

$red = imagecolorallocate($image, 255, 0, 0);
$green = imagecolorallocate($image, 0, 255, 0);
$blue = imagecolorallocate($image, 100, 100, 255);


function updateColor ($x, $y, $column, $line)
{
    global $image;
    global $type, $nbMaxIterations;
    global $white, $black, $red, $green, $blue;

    if ($type == 'julia') {
        [$c_re, $c_im] = [$_GET['julia_a'], $_GET['julia_b']];
        [$z_re, $z_im] = [$x, $y];
    }
    else if ($type == 'mandelbrot') {
        [$c_re, $c_im] = [$x, $y];
        [$z_re, $z_im] = [0, 0];
    }

    for ($i=0; $i<$nbMaxIterations; $i++) {
        $old_z_re = $z_re;
        $z_re = $z_re*$z_re - $z_im*$z_im + $c_re;
        $z_im = 2*$old_z_re*$z_im + $c_im;

        if ($z_re*$z_re + $z_im*$z_im > 4) {
            imagesetpixel($image, $column, $line, imagecolorallocate($image, intval(255 * log($i+1) / log($nbMaxIterations)), 50, 50));
            return;
        }
    }

    imagesetpixel($image, $column, $line, $white);
}


for ($column=0; $column<$WIDTH; $column++) {
    $x = $size / $WIDTH * $column + $centerX - $size/2;

    for ($line=0; $line<$HEIGHT; $line++) {
        $y = -$size / $HEIGHT * $line + $centerY + $size/2;

        updateColor($x, $y, $column, $line);
    }
}

imagepng($image);
