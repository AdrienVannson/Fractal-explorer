<?php

class Complex
{
    public $x, $y;

    public function __construct ($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }
}

function add ($a, $b)
{
    return new Complex($a->x + $b->x, $a->y + $b->y);
}

function multiply ($a, $b)
{
    return new Complex($a->x*$b->x - $a->y*$b->y, $a->x*$b->y + $b->x*$a->y);
}

function norm ($z)
{
    return sqrt($z->x*$z->x + $z->y*$z->y);
}

header("Content-type: image/png");

$size = 1 / pow(2, $_GET['z']);

$centerX = $_GET['x'] * $size + $size/2;
$centerY = -$_GET['y'] * $size - $size/2;


$HEIGHT = 256;
$WIDTH = 256;

$image = imagecreatetruecolor($WIDTH, $HEIGHT);

$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);

$red = imagecolorallocate($image, 255, 0, 0);
$green = imagecolorallocate($image, 0, 255, 0);
$blue = imagecolorallocate($image, 100, 100, 255);

for ($line=0; $line<$HEIGHT; $line++) {
    $y = -$size / $HEIGHT * $line + $centerY + $size/2;

    for ($column=0; $column<$WIDTH; $column++) {
        $x = $size / $WIDTH * $column + $centerX - $size/2;

        $success = false;

        $c = new Complex ($x, $y);
        $z = new Complex (0, 0);

        for ($i=0; $i<50; $i++) {
            $z = add(multiply($z, $z), $c);

            if (norm($z) > 2) {
                $success = true;
                imagesetpixel($image, $column, $line, imagecolorallocate($image, intval(255 * log($i+1) / log(50)), 50, 50));
                break;
            }
        }

        if (!$success) {
            imagesetpixel($image, $column, $line, $white);
        }
    }
}

imagepng($image);
