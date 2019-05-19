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

$type = $_GET['type'];
$nbMaxIterations = $_GET['nbMaxIterations'];

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
        $c = new Complex ($_GET['julia_a'], $_GET['julia_b']);
        $z = new Complex ($x, $y);
    }
    else if ($type == 'mandelbrot') {
        $c = new Complex ($x, $y);
        $z = new Complex (0, 0);
    }

    for ($i=0; $i<$nbMaxIterations; $i++) {
        $z = add(multiply($z, $z), $c);

        if (norm($z) > 2) {
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
