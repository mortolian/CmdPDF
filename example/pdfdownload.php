<?php

include_once '../vendor/autoload.php';

use CmdPdf\Wkhtmltopdf;

$pdf = new Wkhtmltopdf('https://www.google.com');
$pdf->setOptions(array('--footer-center "Page [page] of [topage]"','-s A4'));
$pdf->download('google.pdf', Wkhtmltopdf::DISPOSITION_DOWNLOAD);