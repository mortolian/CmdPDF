<?php

include_once '../vendor/autoload.php';

use CmdPdf\PreviewImage;

$img = new PreviewImage('pdf/example.pdf');
$img->setImageType(PreviewImage::FILE_TYPE_JPG);
$img->setImageQuality('100');
$img->setImageSize('50%');
$image = $img->saveImage(PreviewImage::OUTPUT_BASE64, 1);
echo $image;