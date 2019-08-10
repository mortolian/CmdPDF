<?php

include_once '../vendor/autoload.php';

use CmdPdf\Wkhtmltopdf;

$pdf = new Wkhtmltopdf('https://www.google.com');
$pdf->download('google.pdf');
